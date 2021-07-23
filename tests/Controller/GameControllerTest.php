<?php

namespace App\Tests\Controller;

use App\Service\GameService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public function testStart(): void
    {
        $client = static::createClient();

        $container = static::getContainer();

        $gameService = $this->createMock(GameService::class);
        $gameService->expects($this->once())
            ->method('purge');
        $gameService->expects($this->once())
            ->method('init');

        $container->set(GameService::class, $gameService);

        $client->request('POST', '/start');

        $response = $client->getResponse();
        $this->assertResponseIsSuccessful($response);
    }
}
