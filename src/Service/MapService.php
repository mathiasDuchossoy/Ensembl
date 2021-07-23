<?php

namespace App\Service;

use App\Entity\Map;
use App\Entity\Player;
use App\Entity\Position;
use App\Entity\Target;

class MapService
{
    private PlayerService $playerService;
    private PositionService $positionService;

    public function __construct(PlayerService $playerService, PositionService $positionService)
    {
        $this->playerService = $playerService;
        $this->positionService = $positionService;
    }

    public function convertToGraphicalRepresentation(Target $target, Player $player): string
    {
        $targetPosition = $this->playerService->isNearTarget($player, $target) ? $target->getPosition() : null;
        $playerPosition = $player->getPosition();

        $map = '';
        for ($x = 1; $x <= Map::SQUARES_NUMBER; $x++) {
            $map .= '+--';
        }
        $map .= '+' . PHP_EOL;

        for ($y = 1; $y <= Map::SQUARES_NUMBER; $y++) {
            $map .= '|';
            for ($x = 1; $x <= Map::SQUARES_NUMBER; $x++) {
                $box = $this->getGraphicalBox($targetPosition, $playerPosition, $x, $y);
                $map .= $box . '|';
            }
            $map .= PHP_EOL;
            for ($x = 1; $x <= Map::SQUARES_NUMBER; $x++) {
                $map .= '+--';
            }
            $map .= '+' . PHP_EOL;
        }

        return $map;
    }

    private function getGraphicalBox(?Position $targetPosition, Position $playerPosition, int $x, int $y): string
    {
        $positionHasSameCoordinates = $this->positionService->hasSameCoordinates($targetPosition, $x, $y);
        $playerHasSameCoordinates = $this->positionService->hasSameCoordinates($playerPosition, $x, $y);

        if ($positionHasSameCoordinates && $playerHasSameCoordinates) {
            return 'pc';
        }
        if ($positionHasSameCoordinates) {
            return ' c';
        }
        if ($playerHasSameCoordinates) {
            return ' p';
        }
        return '  ';
    }
}
