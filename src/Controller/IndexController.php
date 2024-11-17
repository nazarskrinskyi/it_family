<?php

declare(strict_types=1);

namespace App\Controller;

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
        $mainCharacter = $this->mainCharacterRepository->findOneBy([], ['id' => 'DESC']);
        $dialogs = $this->dialogRepository->findOneBy(['parentDialog' => null], ['id' => 'DESC']);

        return $this->render('index.html.twig', [
            'mainCharacter' => $mainCharacter,
            'dialogs' => $dialogs
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