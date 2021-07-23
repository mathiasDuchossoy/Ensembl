<?php

namespace App\Tests\Service;

use App\Entity\Position;
use App\Service\PositionService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PositionServiceTest extends KernelTestCase
{
    /**
     * @var PositionService|object|null
     */
    private $positionService;

    public function testDown(): void
    {
        $position = $this->getPosition('down');

        $position->expects($this->exactly(2))
            ->method('getY')
            ->willReturnOnConsecutiveCalls(2, 1);

        $this->positionService->down($position);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('out of map.');
        $this->positionService->down($position);
    }

    private function getPosition(string $method)
    {
        $position = $this->createMock(Position::class);

        $position->expects($this->once())
            ->method($method);

        return $position;
    }

    public function testRight(): void
    {
        $position = $this->getPosition('right');

        $position->expects($this->exactly(2))
            ->method('getX')
            ->willReturn(20, 21);

        $this->positionService->right($position);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('out of map.');
        $this->positionService->right($position);
    }

    public function testUp(): void
    {
        $position = $this->getPosition('up');

        $position->expects($this->exactly(2))
            ->method('getY')
            ->willReturn(20, 21);

        $this->positionService->up($position);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('out of map.');
        $this->positionService->up($position);
    }

    public function testLeft(): void
    {
        $position = $this->getPosition('left');

        $position->expects($this->exactly(2))
            ->method('getX')
            ->willReturn(2, 1);

        $this->positionService->left($position);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('out of map.');
        $this->positionService->left($position);
    }

    public function testHasSameCoordinates(): void
    {
        $position = new Position(1, 2);

        $hasSameCoordinates = $this->positionService->hasSameCoordinates($position, 1, 2);
        $this->assertEquals(true, $hasSameCoordinates);
    }

    public function testHasNotSameCoordinates(): void
    {
        $position = new Position(1, 3);

        $hasSameCoordinates = $this->positionService->hasSameCoordinates($position, 1, 2);
        $this->assertEquals(false, $hasSameCoordinates);
    }

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $container = static::getContainer();
        $this->positionService = $container->get(PositionService::class);
    }
}
