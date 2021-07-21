<?php

namespace App\Service;

use App\Entity\Map;
use App\Entity\Position;
use Exception;

class PositionService
{
    /**
     * @throws Exception
     */
    public function up(Position $position): void
    {
        if ($position->getY() === Map::SQUARES_NUMBER) {
            $this->throwException();
        }

        $position->up();
    }

    /**
     * @throws Exception
     */
    private function throwException(): void
    {
        throw new Exception('out of map.');
    }

    /**
     * @throws Exception
     */
    public function down(Position $position): void
    {
        if ($position->getY() === 1) {
            $this->throwException();
        }

        $position->down();
    }

    /**
     * @throws Exception
     */
    public function left(Position $position): void
    {
        if ($position->getX() === 0) {
            $this->throwException();
        }

        $position->left();
    }

    /**
     * @throws Exception
     */
    public function right(Position $position): void
    {
        if ($position->getX() === Map::SQUARES_NUMBER) {
            $this->throwException();
        }

        $position->right();
    }
}
