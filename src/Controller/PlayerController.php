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
    private GameRepository $gameRepository;
    private PlayerService $playerService;

    public function __construct(GameRepository $gameRepository, PlayerService $playerService)
    {
        $this->gameRepository = $gameRepository;
        $this->playerService = $playerService;
    }

    /**
     * @Route("/move", name="player_move", methods={"POST"})
     */
    public function move(Request $request): JsonResponse
    {
        $game = $this->gameRepository->findOneBy([]);

        if (null === $game) {
            return $this->json('no game.', JsonResponse::HTTP_NOT_FOUND);
        }

        $action = $request->get('action');

        if (null === $action) {
            return $this->json('action missing.', JsonResponse::HTTP_BAD_REQUEST);
        }

        $player = $game->getPlayer();
        try {
            $this->playerService->move($player, $action);
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $target = $game->getMap()->getTarget();

        $response = [
            'position' => $player->getPosition()->jsonSerialize(),
            'target' => $this->playerService->isNearTarget($player, $target) ? $target->getPosition()->jsonSerialize() : null,
        ];

        return $this->json($response);
    }

    /**
     * @Route("/shoot", name="player_shoot", methods={"POST"})
     */
    public function shoot(Request $request): JsonResponse
    {
        $game = $this->gameRepository->findOneBy([]);

        if (null === $game) {
            return $this->json('no game.', JsonResponse::HTTP_NOT_FOUND);
        }

        $x = $request->get('x');

        if (null === $x) {
            return $this->json('x missing.', JsonResponse::HTTP_BAD_REQUEST);
        }

        $y = $request->get('y');

        if (null === $y) {
            return $this->json('y missing.', JsonResponse::HTTP_BAD_REQUEST);
        }

        $state = $this->playerService->shoot($game->getMap()->getTarget(), $x, $y);

        return $this->json(['result' => $state]);
    }
}
