<?php

namespace App\Service;

use App\Entity\Game;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

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
     * autre exempple de récupération du jeu
     * @throws EntityNotFoundException
     */
    public function getOneOrFail(): Game
    {
        $game = $this->gameRepository->findOneBy([]);

        if (null === $game) {
            throw new EntityNotFoundException('no game.');
        }

        return $game;
    }
}
