<?php

namespace App\Tests\Controller;

use App\Entity\Game;
use App\Entity\Map;
use App\Entity\Player;
use App\Entity\Position;
use App\Entity\Target;
use App\Repository\GameRepository;
use App\Service\PlayerService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    public function testMoveAndIsNearTarget(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        $targetPosition = $this->createMock(Position::class);
        $targetPosition->method('jsonSerialize')
            ->willReturn(['x' => 10, 'y' => 11]);

        $target = $this->createMock(Target::class);
        $target->method('getPosition')
            ->willReturn($targetPosition);

        $map = $this->createMock(Map::class);
        $map->method('getTarget')
            ->willReturn($target);

        $playerPosition = $this->createMock(Position::class);
        $playerPosition->method('jsonSerialize')
            ->willReturn(['x' => 11, 'y' => 12]);

        $player = $this->createMock(Player::class);
        $player->method('getPosition')
            ->willReturn($playerPosition);

        $game = $this->createMock(Game::class);
        $game->method('getPlayer')
            ->willReturn($player);
        $game->method('getMap')
            ->willReturn($map);

        $gameRepository = $this->createMock(GameRepository::class);
        $gameRepository->expects($this->once())
            ->method('findOneBy')
            ->willReturn($game);

        $container->set(GameRepository::class, $gameRepository);

        $playerService = $this->createMock(PlayerService::class);
        $playerService->expects($this->once())
            ->method('move');

        $game->method('getPlayer')->willReturn($player);

        $playerService->expects($this->once())
            ->method('isNearTarget')
            ->willReturn(true);

        $container->set(PlayerService::class, $playerService);

        $client->request('POST', '/move', ['action' => 'up']);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $content = $client->getResponse()->getContent();
        $this->assertJson($content);

        $content = json_decode($content, true);

        $this->assertArrayHasKey('position', $content);
        $this->assertArrayHasKey('x', $content['position']);
        $this->assertArrayHasKey('y', $content['position']);
        $this->assertArrayHasKey('target', $content);
        $this->assertArrayHasKey('x', $content['target']);
        $this->assertArrayHasKey('y', $content['target']);

        $this->assertEquals(11, $content['position']['x']);
        $this->assertEquals(12, $content['position']['y']);
        $this->assertEquals(10, $content['target']['x']);
        $this->assertEquals(11, $content['target']['y']);
    }

    public function testMoveWithNoGame()
    {
        $client = static::createClient();
        $container = static::getContainer();

        $gameRepository = $this->createMock(GameRepository::class);
        $gameRepository->expects($this->once())
            ->method('findOneBy')
            ->willReturn(null);

        $container->set(GameRepository::class, $gameRepository);

        $client->request('POST', '/move', ['action' => 'up']);

        $this->assertResponseStatusCodeSame(404);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $content = $client->getResponse()->getContent();
        $this->assertJson($content);

        $content = json_decode($content, true);
        $this->assertEquals('no game.', $content);
    }

    public function testMoveWithoutAction()
    {
        $client = static::createClient();
        $container = static::getContainer();

        $game = $this->createMock(Game::class);
        $gameRepository = $this->createMock(GameRepository::class);
        $gameRepository->expects($this->once())
            ->method('findOneBy')
            ->willReturn($game);

        $container->set(GameRepository::class, $gameRepository);
        $client->request('POST', '/move');

        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $content = $client->getResponse()->getContent();
        $this->assertJson($content);

        $content = json_decode($content, true);
        $this->assertEquals('action missing.', $content);
    }

    public function testMoveAndIsNotNearTarget()
    {
        $client = static::createClient();
        $container = static::getContainer();

        $targetPosition = $this->createMock(Position::class);
        $targetPosition->method('jsonSerialize')
            ->willReturn(['x' => 5, 'y' => 5]);

        $target = $this->createMock(Target::class);
        $target->method('getPosition')
            ->willReturn($targetPosition);

        $map = $this->createMock(Map::class);
        $map->method('getTarget')
            ->willReturn($target);

        $playerPosition = $this->createMock(Position::class);
        $playerPosition->method('jsonSerialize')
            ->willReturn(['x' => 11, 'y' => 12]);

        $player = $this->createMock(Player::class);
        $player->method('getPosition')
            ->willReturn($playerPosition);

        $game = $this->createMock(Game::class);
        $game->method('getPlayer')
            ->willReturn($player);
        $game->method('getMap')
            ->willReturn($map);

        $gameRepository = $this->createMock(GameRepository::class);
        $gameRepository->expects($this->once())
            ->method('findOneBy')
            ->willReturn($game);

        $container->set(GameRepository::class, $gameRepository);

        $playerService = $this->createMock(PlayerService::class);
        $playerService->expects($this->any())
            ->method('move');

        $playerService->expects($this->once())
            ->method('isNearTarget')
            ->willReturn(false);

        $container->set(PlayerService::class, $playerService);

        $client->request('POST', '/move', ['action' => 'up']);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $content = $client->getResponse()->getContent();
        $this->assertJson($content);

        $content = json_decode($content, true);

        $this->assertArrayHasKey('position', $content);
        $this->assertArrayHasKey('x', $content['position']);
        $this->assertArrayHasKey('y', $content['position']);
        $this->assertArrayHasKey('target', $content);

        $this->assertEquals(11, $content['position']['x']);
        $this->assertEquals(12, $content['position']['y']);
        $this->assertEquals(null, $content['target']);
    }

    public function testMoveWithWrongAction()
    {
        $client = static::createClient();
        $container = static::getContainer();

        $player = $this->createMock(Player::class);
        $game = $this->createMock(Game::class);
        $game->method('getPlayer')->willReturn($player);

        $gameRepository = $this->createMock(GameRepository::class);
        $gameRepository->expects($this->once())
            ->method('findOneBy')
            ->willReturn($game);

        $container->set(GameRepository::class, $gameRepository);

        $playerService = $this->createMock(PlayerService::class);
        $playerService->method('move')
            ->willThrowException(new \Exception());

        $client->request('POST', '/move', ['action' => 'top_right']);

        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $content = $client->getResponse()->getContent();
        $this->assertJson($content);

        $content = json_decode($content, true);
        $this->assertEquals('action not exists.', $content);
    }
}
