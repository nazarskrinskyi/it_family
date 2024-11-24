<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Dialog;
use App\Entity\FamilyMember;
use App\Entity\MainCharacter;
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
        if (!$this->mainCharacterRepository->findOneBy(['isActive' => true], ['id' => 'DESC'])) {
            return $this->redirect('/admin');
        }

        return $this->render('index.html.twig', [
            'main_character' => $this->mainCharacterRepository->findOneBy(['isActive' => true], ['id' => 'DESC']),
        ]);
    }

    #[Route('/dialog/{memberId}', name: 'app_dialog_index', methods: ['GET'])]
    public function getDialog(int $memberId): Response
    {
        $mainCharacter = $this->mainCharacterRepository->findOneBy(['isActive' => true], ['id' => 'DESC']);
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
        /** @var Dialog $dialog */
        $dialog = $this->dialogRepository->findOneBy(['parentDialog' => $dialogId, 'selectedAnswer' => $answerId]);
        /** @var Answer $answer */
        $answer = $this->answerRepository->find($answerId);

        /** @var FamilyMember $member */
        $member =  $dialog?->getMembers()->last();
        /** @var MainCharacter $mainCharacter */
        $mainCharacter = $this->mainCharacterRepository->findOneBy(['isActive' => true], ['id' => 'DESC']);

        $memberData = $answer && $member ? [
            'image' => null,
            'emoji' => $answer->getEmoji(),
            'reactions' => $answer->getReactions(),
            'mood' => $member->setMood(max(0, min(100, $member->getMood() + (int)$answer->getMood())))->getMood(),
            'hunger' => $member->setHunger(max(0, min(100, $member->getHunger() + (int)$answer->getHunger())))->getHunger(),
            'health' => $member->setHealth(max(0, min(100, $member->getHealth() + (int)$answer->getHealth())))->getHealth(),
            'energy' => $member->setEnergy(max(0, min(100, $member->getEnergy() + (int)$answer->getEnergy())))->getEnergy(),
            'stress' => $member->setStress(max(0, min(100, $member->getStress() + (int)$answer->getStress())))->getStress(),
            'state' => $mainCharacter->updateState()->getState(),
        ] : null;


        if (!$dialog) {
            return new JsonResponse([
                'last' => true,
                'member' => $memberData, // Selected member data
            ]);
        }

        $mainCharacterData =  [
            'image' => null,
            'emoji' => $dialog->getEmoji(),
            'reactions' => $dialog->getReactions(),
            'mood' => $mainCharacter->setMood(max(0, min(100, $mainCharacter->getMood() + (int)$answer->getMood())))->getMood(),
            'hunger' => $mainCharacter->setHunger(max(0, min(100, $mainCharacter->getHunger() + (int)$answer->getHunger())))->getHunger(),
            'health' => $mainCharacter->setHealth(max(0, min(100, $mainCharacter->getHealth() + (int)$answer->getHealth())))->getHealth(),
            'energy' => $mainCharacter->setEnergy(max(0, min(100, $mainCharacter->getEnergy() + (int)$answer->getEnergy())))->getEnergy(),
            'stress' => $mainCharacter->setStress(max(0, min(100, $mainCharacter->getStress() + (int)$answer->getStress())))->getStress(),
            'state' => $mainCharacter->updateState()->getState(),
        ] ;

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
            'last' => false,
        ]);
    }
}