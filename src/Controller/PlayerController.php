<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Service\PlayerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    /**
     * @Route("/move", name="move", methods={"POST"})
     */
    public function move(Request $request, GameRepository $gameRepository, PlayerService $playerService): JsonResponse
    {
        $game = $gameRepository->findOneBy([]);

        if (null === $game) {
            return $this->json('no game.', JsonResponse::HTTP_NOT_FOUND);
        }

        $action = $request->get('action');

        if (null === $action) {
            return $this->json('action missing.', JsonResponse::HTTP_BAD_REQUEST);
        }

        $player = $game->getPlayer();
        try {
            $playerService->move($player, $action);
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $target = $game->getMap()->getTarget();

        $response = [
            'position' => $player->getPosition()->jsonSerialize(),
            'target' => $playerService->isNearTarget($player, $target) ? $target->getPosition()->jsonSerialize() : null,
        ];

        return $this->json($response);
    }
}
