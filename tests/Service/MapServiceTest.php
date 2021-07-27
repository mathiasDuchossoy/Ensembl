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

    private function getMapGraphReprExcepted(): string
    {
        return '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |21' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |20' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |19' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |18' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |17' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |16' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |15' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |14' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |13' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |12' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |11' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |10' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |9' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |8' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |7' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |6' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |5' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |4' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |3' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |pc|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |2' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |1' . PHP_EOL .
            '+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+' . PHP_EOL .
            '  1  2  3  4  5  6  7  8  9 10 11 12 13 14 15 16 17 18 19 20 21 ' . PHP_EOL;
    }
}
