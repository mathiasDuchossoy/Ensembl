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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/start", name="game_start", methods={"POST"})
     * @throws Exception
     */
    public function start(GameService $gameService): JsonResponse
    {
        $gameService->purge();

        $targetPosition = new Position(random_int(1, Map::SQUARES_NUMBER), random_int(1, Map::SQUARES_NUMBER));

        $target = new Target($targetPosition);
        $map = new Map($target);

        $mapCenterPosition = round(Map::SQUARES_NUMBER / 2);
        $playerPosition = new Position($mapCenterPosition, $mapCenterPosition);

        $player = new Player($playerPosition);

        $game = new Game($map, $player);

        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
