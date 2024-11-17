<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Repository\DialogRepository;
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
        private readonly DialogRepository $dialogRepository
    ) {
    }

    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        return $this->render('index.html.twig', [
            'main_character' => $this->mainCharacterRepository->findOneBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/dialog/{memberId}', name: 'app_dialog_index', methods: ['GET'])]
    public function getDialog(int $memberId): Response
    {
        $mainCharacter = $this->mainCharacterRepository->findOneBy([], ['id' => 'DESC']);
        $dialog = $this->dialogRepository->findDialogByMemberAndParent($memberId);

        return $this->render('dialog.html.twig', [
            'main_character' => $mainCharacter,
            'dialog' => $dialog
        ]);
    }

    #[Route('/api/dialog/{answerId}/{dialogId}', name: 'api_get_dialog', methods: ['GET'])]
    public function fetchDialogByAnswer(int $answerId, int $dialogId): JsonResponse
    {
        $dialog = $this->dialogRepository->findOneBy(['parentDialog' => $dialogId, 'selectedAnswer' => $answerId]);

        if (!$dialog) {
            return new JsonResponse(['error' => 'Dialog not found'], 404);
        }

        return new JsonResponse([
            'name' => $dialog->getName(),
            'content' => $dialog->getContent(),
            'answers' => array_map(function (Answer $answer) {
                return [
                    'id' => $answer->getId(),
                    'content' => $answer->getContent(),
                    'emoji' => $answer->getEmoji(),
                    'reactions' => $answer->getReactions(),
                ];
            }, $dialog->getAnswers()->toArray()),
            'emoji' => $dialog->getEmoji(),
            'reactions' => $dialog->getReactions(),
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