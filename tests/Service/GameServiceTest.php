<?php

namespace App\Tests\Service;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Service\GameService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GameServiceTest extends KernelTestCase
{
    public function testPurge(): void
    {
        $games = [];
        for ($i = 0; $i < 10; $i++) {
            $games[] = $this->createMock(Game::class);
        }

        $gameRepository = $this->createMock(GameRepository::class);
        $gameRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($games);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('remove');
        $entityManager->expects($this->once())
            ->method('flush');

        $gameService = new GameService($entityManager, $gameRepository);

        $gameService->purge();
    }
}
