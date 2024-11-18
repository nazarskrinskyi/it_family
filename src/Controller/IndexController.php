<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Repository\AnswerRepository;
use App\Repository\DialogRepository;
use App\Repository\FamilyMemberRepository;
use App\Repository\MainCharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    public function __construct(
        private readonly MainCharacterRepository $mainCharacterRepository,
        private readonly DialogRepository $dialogRepository,
        private readonly FamilyMemberRepository $familyMemberRepository,
        private readonly AnswerRepository $answerRepository
    ) {
    }

    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        if (!$this->mainCharacterRepository->findOneBy([], ['id' => 'DESC'])) {
            return $this->redirect('/admin');
        }

        return $this->render('index.html.twig', [
            'main_character' => $this->mainCharacterRepository->findOneBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/dialog/{memberId}', name: 'app_dialog_index', methods: ['GET'])]
    public function getDialog(int $memberId): Response
    {
        $mainCharacter = $this->mainCharacterRepository->findOneBy([], ['id' => 'DESC']);
        $member = $this->familyMemberRepository->find($memberId);
        $dialog = $this->dialogRepository->findDialogByMemberAndParent($memberId);

        return $this->render('dialog.html.twig', [
            'main_character' => $mainCharacter,
            'member' => $member,
            'dialog' => $dialog
        ]);
    }

    #[Route('/api/dialog/{answer}/{dialogId}', name: 'api_get_dialog', methods: ['GET'])]
    public function fetchDialogByAnswer(string $answer, int $dialogId): JsonResponse
    {
        [$answerId, $position] = explode('-', $answer);
        $dialog = $this->dialogRepository->findOneBy(['parentDialog' => $dialogId, 'selectedAnswer' => $position]);
        $answer = $this->answerRepository->find($answerId);

        if (!$dialog) {
            return new JsonResponse(['error' => 'Dialog not found'], 404);
        }

        $mainCharacterData =  [
            'image' => null,
            'emoji' => $dialog->getEmoji(),
            'reactions' => $dialog->getReactions(),
        ] ;

        $memberData = $answer ? [
            'image' => null,
            'emoji' => $answer->getEmoji(),
            'reactions' => $answer->getReactions(),
        ] : null;

        $i = 0;

        return new JsonResponse([
            'id' => $dialog->getId(),
            'name' => $dialog->getName(),
            'content' => $dialog->getContent(),
            'answers' => array_map(function (Answer $answer) use (&$i) {
                return [
                    'id' => $answer->getId(),
                    'content' => $answer->getContent(),
                    'position' => $i++,
                ];
            }, $dialog->getAnswers()->toArray()),
            'backgroundImage' => $dialog->getImage(),
            'mainCharacter' => $mainCharacterData, // Main character data
            'member' => $memberData, // Selected member data
        ]);
    }

    #[Route('/api/new-dialogs', name: 'app_new_dialogs', methods: ['POST, GET'])]
    public function getNewDialogs(Request $request): JsonResponse
    {
        $dialogId = $request->get('dialogId');
        $answerId = $request->get('answerId');

        $dialog = $this->dialogRepository->findOneBy(['parentDialog' => $dialogId, 'selectedAnswer' => $answerId]);

        return new JsonResponse($dialog);
    }
}