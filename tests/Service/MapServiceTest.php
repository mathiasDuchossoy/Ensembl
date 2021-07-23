<?php

namespace App\Tests\Service;

use App\Entity\Player;
use App\Entity\Position;
use App\Entity\Target;
use App\Service\MapService;
use App\Service\PlayerService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MapServiceTest extends KernelTestCase
{
    public function testConvertToGraphicalRepresentation(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $playerService = $this->createMock(PlayerService::class);
        $playerService->method('isNearTarget')
            ->willReturn(true);

        $container->set(PlayerService::class, $playerService);

        $target = new Target(new Position(2, 2));
        $player = new Player(new Position(2, 2));

        $mapService = $container->get(MapService::class);

        $mapGraphRepr = $mapService->convertToGraphicalRepresentation($target, $player);

        $mapGraphReprExcepted = $this->getMapGraphReprExcepted();

        $this->assertEquals($mapGraphReprExcepted, $mapGraphRepr);
    }

    private function getMapGraphReprExcepted(): string
    {
        return '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |pc|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL;
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetGraphicalBox(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $mapService = $container->get(MapService::class);

        $reflectionClass = new \ReflectionClass($mapService);
        $reflectionMethod = $reflectionClass->getMethod('getGraphicalBox');
        $reflectionMethod->setAccessible(true);

        $targetPosition = new Position(2, 2);
        $playerPosition = new Position(2, 2);

        $result = $reflectionMethod->invoke($mapService, $targetPosition, $playerPosition, 2, 2);

        $this->assertEquals('pc', $result);

        $playerPosition = new Position(2, 3);

        $result = $reflectionMethod->invoke($mapService, $targetPosition, $playerPosition, 2, 2);

        $this->assertEquals(' c', $result);

        $targetPosition = new Position(2, 4);
        $playerPosition = new Position(2, 2);

        $result = $reflectionMethod->invoke($mapService, $targetPosition, $playerPosition, 2, 2);

        $this->assertEquals(' p', $result);

        $targetPosition = new Position(2, 4);
        $playerPosition = new Position(2, 4);

        $result = $reflectionMethod->invoke($mapService, $targetPosition, $playerPosition, 2, 2);

        $this->assertEquals('  ', $result);
    }
}
