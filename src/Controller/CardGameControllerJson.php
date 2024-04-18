<?php

namespace App\Controller;


use App\Card\DeckOfCards;
use App\Card\CardHand;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

date_default_timezone_set("Europe/Stockholm");

class CardGameControllerJson extends AbstractController
{
    #[Route("/api/deck/init", name: "deck_init",  methods: ["GET"])]
    public function initcallback(SessionInterface $session): Response 
    {
        $deck = new DeckOfCards();
        $session->set("cards_left_in_deck", $deck);
        return $this->redirectToRoute('deck');
    }

    #[Route("/api/deck", name: "deck", methods: ["GET"])]
    public function jsonDeck(SessionInterface $session): Response
    {
          $deck = $session->get("cards_left_in_deck");
        if ($deck == null) {
            return $this->redirectToRoute('deck_init');
        }
        
        // Hämta kortleken som en array av kortrepresentationer
        $deckData = [];
        foreach ($deck->getDeck() as $card) {
            $deckData[] = $card->representCard();
        }

        $data = [
            "deck" => $deckData
        ];
        
        $session->set("cards_left_in_deck", $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "shuffle", methods: ["GET"])]
    public function jsonShuffle(SessionInterface $session): Response
    {
        $deck = $session->get("cards_left_in_deck");
        $shuffleDeck = $deck->getDeck();

        shuffle($shuffleDeck);

        
        // Hämta kortleken som en array av kortrepresentationer
        $deckData = [];
        foreach ($shuffleDeck as $card) {
            $deckData[] = $card->representCard();
        }

        $data = [
            "deck" => $deckData
        ];
        $session->set("cards_left_in_deck", $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "draw", methods: ["POST"])]
    public function jsonDraw(SessionInterface $session): Response
    {
       
    }
}
