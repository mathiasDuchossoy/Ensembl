<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Map;
use App\Entity\Player;
use App\Entity\Position;
use App\Entity\Target;
use App\Service\GameService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/start", name="game_start", methods={"POST"})
     * @throws Exception
     */
    public function start(GameService $gameService, EntityManagerInterface $entityManager): JsonResponse
    {
        $gameService->purge();

        $gameService->init();

        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
