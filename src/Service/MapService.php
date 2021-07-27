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

        $squaresNumber = Map::SQUARES_NUMBER;

        $map = '';
        for ($x = 1; $x <= $squaresNumber; $x++) {
            $map .= '+--';
        }
        $map .= '+' . PHP_EOL;

        for ($y = $squaresNumber; $y > 0; $y--) {
            $map .= '|';
            for ($x = 1; $x <= $squaresNumber; $x++) {
                $box = $this->getGraphicalBox($targetPosition, $playerPosition, $x, $y);
                $map .= $box . '|';
            }
            $map .= $y . PHP_EOL;
            for ($x = 1; $x <= $squaresNumber; $x++) {
                $map .= '+--';
            }
            $map .= '+' . PHP_EOL;
        }

        $map .= '';
        for ($x = 1; $x <= $squaresNumber; $x++) {
            $map .= $x < 10 ? '  ' : ' ';
            $map .= $x;
        }
        $map .= ' ' . PHP_EOL;

        return $map;
    }

    private function getGraphicalBox(?Position $targetPosition, Position $playerPosition, int $x, int $y): string
    {
        $targetHasSameCoordinates = $this->positionService->hasSameCoordinates($targetPosition, $x, $y);
        $playerHasSameCoordinates = $this->positionService->hasSameCoordinates($playerPosition, $x, $y);

        if ($targetHasSameCoordinates && $playerHasSameCoordinates) {
            return 'pc';
        }
        if ($targetHasSameCoordinates) {
            return ' c';
        }
        if ($playerHasSameCoordinates) {
            return ' p';
        }
        return '  ';
    }
}
