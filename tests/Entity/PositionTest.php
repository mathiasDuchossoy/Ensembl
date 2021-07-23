<?php

namespace App\Tests\Entity;

use App\Entity\Position;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    public function testPositionCreate(): void
    {
        $position = new Position(1, 1);

        $this->assertEquals(1, $position->getX());
        $this->assertEquals(1, $position->getY());

        $position->up();
        $this->assertEquals(2, $position->getY());

        $position->down();
        $this->assertEquals(1, $position->getY());

        $position->right();
        $this->assertEquals(2, $position->getX());

        $position->left();
        $this->assertEquals(1, $position->getX());

        $positionJsonSerialize = $position->jsonSerialize();
        $this->assertEquals(1, $positionJsonSerialize['x']);
        $this->assertEquals(1, $positionJsonSerialize['y']);
    }
}
