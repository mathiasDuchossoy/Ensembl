<?php

namespace App\Tests\Service;

use App\Entity\Player;
use App\Entity\Position;
use App\Entity\Target;
use App\Service\PlayerService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PlayerServiceTest extends KernelTestCase
{
    public function testIsNearTarget(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $playerService = $container->get(PlayerService::class);

        $playerPosition = new Position(4, 4);
        $player = new Player($playerPosition);

        $wrongPositions = $this->getWrongPositions();

        foreach ($wrongPositions as $wrongPosition) {
            $targetPosition = new Position($wrongPosition[0], $wrongPosition[1]);
            $target = new Target($targetPosition);

            $isNearTarget = $playerService->isNearTarget($player, $target);
            echo $wrongPosition[0] . ':' . $wrongPosition[1];
            $this->assertFalse($isNearTarget);
        }

        $goodPositions = $this->getGoodPositions();

        foreach ($goodPositions as $goodPosition) {
            $targetPosition = new Position($goodPosition[0], $goodPosition[1]);
            $target = new Target($targetPosition);

            $isNearTarget = $playerService->isNearTarget($player, $target);
            echo $goodPosition[0] . ':' . $goodPosition[1];
            $this->assertTrue($isNearTarget);
        }
    }

    private function getWrongPositions(): array
    {
        return [
            [3, 1],
            [4, 1],
            [5, 1],
            [2, 2],
            [3, 2],
            [5, 2],
            [6, 2],
            [1, 3],
            [2, 3],
            [6, 3],
            [7, 3],
            [1, 4],
            [7, 4],
            [1, 5],
            [2, 5],
            [6, 5],
            [7, 5],
            [2, 6],
            [3, 6],
            [5, 6],
            [6, 6],
            [3, 7],
            [4, 7],
            [5, 7],
        ];
    }

    private function getGoodPositions(): array
    {
        return [
            [4, 2],
            [3, 3],
            [4, 3],
            [5, 3],
            [2, 4],
            [3, 4],
            [4, 4],
            [5, 4],
            [6, 4],
            [3, 5],
            [4, 5],
            [5, 5],
            [4, 6],
        ];
    }
}
