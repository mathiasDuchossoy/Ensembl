<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Service\MapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    /**
     * @Route("/map", name="map", methods={"GET"})
     */
    public function index(GameRepository $gameRepository, MapService $mapService): Response
    {
        $game = $gameRepository->findOneBy([]);

        if (null === $game) {
            return $this->json('no game.', JsonResponse::HTTP_NOT_FOUND);
        }

        $map = $mapService->convertToGraphicalRepresentation($game->getMap()->getTarget(), $game->getPlayer());

        return new Response($map);
    }
}
