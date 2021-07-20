<?php

namespace App\Controller;

use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    /**
     * @Route("/move", name="move", methods={"POST"})
     */
    public function move(Request $request): JsonResponse
    {
        $action = $request->get('action');

        if (null === $action) {
            return $this->json('action missing.', JsonResponse::HTTP_BAD_REQUEST);
        }

        if (!in_array($action, Player::ACTIONS, true)) {
            return $this->json('action not exists.', JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->json($action);
    }
}
