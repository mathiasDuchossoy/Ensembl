<?php

namespace App\Service;

use App\Entity\Player;
use App\Entity\Target;
use Doctrine\ORM\EntityManagerInterface;

class PlayerService
{
    private PositionService $positionService;
    private EntityManagerInterface $entityManager;

    public function __construct(PositionService $positionService, EntityManagerInterface $entityManager)
    {
        $this->positionService = $positionService;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Exception
     */
    public function move(Player $player, string $action): void
    {
        $position = $player->getPosition();

        switch ($action) {
            case Player::UP:
                $this->positionService->up($position);
                break;
            case Player::DOWN:
                $this->positionService->down($position);
                break;
            case Player::LEFT:
                $this->positionService->left($position);
                break;
            case Player::RIGHT:
                $this->positionService->right($position);
                break;
            default:
                throw new \Exception('action not exists.');
        }

        $this->entityManager->flush();
    }

    public function isNearTarget(Player $player, Target $target): bool
    {
        $playerPosition = $player->getPosition();
        $playerPositionX = $playerPosition->getX();
        $playerPositionY = $playerPosition->getY();

        $targetPosition = $target->getPosition();
        $targetPositionX = $targetPosition->getX();
        $targetPositionY = $targetPosition->getY();

        if ($playerPositionY === $targetPositionY
            && $this->isInRange($playerPositionX, $targetPositionX, 2)
        ) {
            return true;
        }

        if ($playerPositionX === $targetPositionX
            && $this->isInRange($playerPositionY, $targetPositionY, 2)
        ) {
            return true;
        }

        if ($this->isInRange($playerPositionX, $targetPositionX, 1)
            && $this->isInRange($playerPositionY, $targetPositionY, 1)
        ) {
            return true;
        }

        return false;
    }

    private function isInRange(int $playerPositionAxe, int $targetPositionAxe, int $intervalValue): bool
    {
        return $targetPositionAxe - $intervalValue <= $playerPositionAxe
            && $targetPositionAxe + $intervalValue >= $playerPositionAxe;
    }

    public function shoot(Target $target, int $shootCoordinateX, int $shootCoordinateY): string
    {
        $targetPosition = $target->getPosition();

        if ($shootCoordinateX !== $targetPosition->getX()
            || $shootCoordinateY !== $targetPosition->getY()) {
            return Target::STATE_MISS;
        }

        $target->incrementTouchCount();
        $this->entityManager->flush();

        if (3 <= $target->getTouchCount()) {
            return Target::STATE_KILL;
        }

        return Target::STATE_TOUCH;
    }
}
