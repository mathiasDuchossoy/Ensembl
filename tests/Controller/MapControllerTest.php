<?php

namespace App\Tests\Controller;

use App\Service\MapService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MapControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $container = static::getContainer();

        $mapService = $this->createMock(MapService::class);
        $mapService->expects($this->once())
            ->method('convertToGraphicalRepresentation');

        $container->set(MapService::class, $mapService);

        $client->request('GET', '/map');

        $response = $client->getResponse();
        $this->assertResponseIsSuccessful($response);
    }
}
