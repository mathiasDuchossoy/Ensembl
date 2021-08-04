<?php

namespace App\Tests\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Service\MapService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MapControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $container = static::getContainer();

        $game = $this->createMock(Game::class);
        $gameRepository = $this->createMock(GameRepository::class);
        $gameRepository->method('findOneBy')
            ->willReturn($game);

        $container->set(GameRepository::class, $gameRepository);

        $mapService = $this->createMock(MapService::class);
        $mapService->expects($this->once())
            ->method('convertToGraphicalRepresentation');

        $container->set(MapService::class, $mapService);

        $client->request('GET', '/map');

        $response = $client->getResponse();
        $this->assertResponseIsSuccessful($response);
    }

    public function testIndexWithoutGame()
    {
        $client = static::createClient();
        $container = static::getContainer();

        $gameRepository = $this->createMock(GameRepository::class);
        $gameRepository->method('findOneBy');

        $container->set(GameRepository::class, $gameRepository);

        $client->request('GET', '/map');

        $this->assertResponseStatusCodeSame(404);
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $content = $client->getResponse()->getContent();
        $this->assertJson($content);

        $content = json_decode($content, true);

        $this->assertEquals('no game.', $content);
    }
}
