<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\Map;
use App\Entity\Player;
use App\Entity\Position;
use App\Entity\Target;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;

class GameService
{
    private EntityManagerInterface $entityManager;
    private GameRepository $gameRepository;

    public function __construct(EntityManagerInterface $entityManager, GameRepository $gameRepository)
    {
        $this->entityManager = $entityManager;
        $this->gameRepository = $gameRepository;
    }

    public function purge(): void
    {
        $games = $this->gameRepository->findAll();

        foreach ($games as $game) {
            $this->entityManager->remove($game);
        }

        $this->entityManager->flush();
    }

    /**
     * @throws \Exception
     */
    public function init(): void
    {
        $targetPosition = new Position(random_int(1, Map::SQUARES_NUMBER), random_int(1, Map::SQUARES_NUMBER));

        $target = new Target($targetPosition);
        $map = new Map($target);

        $mapCenterPosition = round(Map::SQUARES_NUMBER / 2);
        $playerPosition = new Position($mapCenterPosition, $mapCenterPosition);

        $player = new Player($playerPosition);

        $game = new Game($map, $player);

        $this->entityManager->persist($game);
        $this->entityManager->flush();
    }
}
