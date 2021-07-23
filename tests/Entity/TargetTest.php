<?php

namespace App\Tests\Entity;

use App\Entity\Position;
use App\Entity\Target;
use PHPUnit\Framework\TestCase;

class TargetTest extends TestCase
{
    public function testIncrementTouchCount(): void
    {
        $position = $this->createMock(Position::class);

        $target = new Target($position);

        $this->assertEquals(0, $target->getTouchCount());

        $target->incrementTouchCount();
        $this->assertEquals(1, $target->getTouchCount());
    }
}
