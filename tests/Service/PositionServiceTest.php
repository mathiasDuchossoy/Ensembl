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
    private $playerService;

    public function testDown(): void
    {
        $position = $this->getPosition('down');

        $position->expects($this->exactly(2))
            ->method('getY')
            ->willReturnOnConsecutiveCalls(2, 1);

        $this->playerService->down($position);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('out of map.');
        $this->playerService->down($position);
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

        $this->playerService->right($position);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('out of map.');
        $this->playerService->right($position);
    }

    public function testUp(): void
    {
        $position = $this->getPosition('up');

        $position->expects($this->exactly(2))
            ->method('getY')
            ->willReturn(20, 21);

        $this->playerService->up($position);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('out of map.');
        $this->playerService->up($position);
    }

    public function testLeft(): void
    {
        $position = $this->getPosition('left');

        $position->expects($this->exactly(2))
            ->method('getX')
            ->willReturn(2, 1);

        $this->playerService->left($position);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('out of map.');
        $this->playerService->left($position);
    }

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $container = static::getContainer();
        $this->playerService = $container->get(PositionService::class);
    }
}
