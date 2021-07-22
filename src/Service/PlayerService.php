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

        if (($playerPositionX - 2 <= $targetPositionX && $targetPositionX <= $playerPositionX + 2)
            && $playerPositionY === $targetPositionY
        ) {
            return true;
        }

        if (($playerPositionY - 2 <= $targetPositionY && $targetPositionY <= $playerPositionY + 2)
            && $playerPositionX === $targetPositionX
        ) {
            return true;
        }

        if ($playerPositionX - 1 <= $targetPositionX && $targetPositionX <= $playerPositionX + 1
            && $playerPositionY - 1 <= $targetPositionY && $targetPositionY <= $playerPositionY + 1
        ) {
            return true;
        }

        return false;
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
