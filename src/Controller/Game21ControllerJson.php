<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Card\Game21;

class Game21ControllerJson extends AbstractController
{
    #[Route("/api/game", name: "game21", methods: ["GET"])]

    public function jsonDeck(SessionInterface $session): Response
    {
        /** @var Game21|null $player1Score, $player2Score */
        $player1Score = $session->get("player1Score");
        $player2Score = $session->get("player2Score");

        $data = [
            "player1Score" => $player1Score, 
            "player2Score" => $player2Score, 
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}