<?php

namespace App\Service;

use App\Entity\Player;
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
}
