<?php
namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Exception;

date_default_timezone_set("Europe/Stockholm");

class CardGameControllerJson extends AbstractController
{
    // Initierar en ny kortlek och sparar den i sessionen
    #[Route("/api/deck/init", name: "deck_init", methods: ["GET"])]
    public function initcallback(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $session->set("cards_left_in_deck", $deck);
        return $this->redirectToRoute('deck');
    }

    // Returnerar kortleken i JSON-format
    #[Route("/api/deck", name: "apideck", methods: ["GET"])]
    public function jsonDeck(SessionInterface $session): Response
    {
        /** @var DeckOfCards|null $deck */
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

        // Returnerar kortleken som JSON med vacker utskrift
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    // Blandar kortleken och returnerar den i JSON-format
    #[Route("/api/deck/shuffle", name: "apishuffle", methods: ["GET"])]
    public function jsonShuffle(SessionInterface $session): Response
    {
        /** @var DeckOfCards|null $deck */
        $deck = $session->get("cards_left_in_deck");

        if ($deck === null) {
            return new Response("Deck is not initialized", Response::HTTP_NOT_FOUND);
        }

        // Kopiera och blanda kortleken
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

        // Returnerar den blandade kortleken som JSON med vacker utskrift
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    // Drar ett kort från kortleken och returnerar informationen i JSON-format
    #[Route("/api/deck/draw", name: "apidraw", methods: ["POST"])]
    public function jsonDraw(SessionInterface $session): Response
    {
        /** @var DeckOfCards|null $deck */
        $deck = $session->get("cards_left_in_deck");

        if ($deck === null) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set("cards_left_in_deck", $deck);
        }

        $hand = new CardHand();
        $drawnCard = $deck->draw();

        // Om det inte finns några kort kvar i kortleken, visa ett meddelande
        if ($drawnCard === null) {
            return new Response("The deck is empty!");
        }

        // Lägg till det dragna kortet i handen
        $hand->add($drawnCard);

        // Spara handen i sessionen
        $session->set("drawn_cards", $hand->getHand());

        // Hämta kortleken som en array av kortrepresentationer
        $deckLeft = [];
        foreach ($deck->getDeck() as $card) {
            $deckLeft[] = $card->representCard();
        }

        $deckDrawn = [];
        foreach ($hand->getHand() as $card) {
            $deckDrawn[] = $card->representCard();
        }

        $deckLeftInt = $deck->countDeck();

        // Returnerar information om dragna kort och kort kvar i leken som JSON
        $data = [
            "cardsLeftInt" => $deckLeftInt,
            "cardsDrawn" => $deckDrawn,
            "cardsLeft" => $deckLeft,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    // Drar ett specificerat antal kort från kortleken och returnerar informationen i JSON-format
    #[Route("/api/deck/draw/{number<\d+>?}", name: "api_drawmany", methods: ["POST"])]
    public function jsonDrawMany(SessionInterface $session, Request $request): Response
    {
        // Hämta värdet för number från requesten
        $number = $request->request->getInt('number', 1); // Använd det skickade värdet för antalet kort

        /** @var DeckOfCards|null $deck */
        $deck = $session->get("cards_left_in_deck");

        if ($deck === null) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set("cards_left_in_deck", $deck);
        }

        // Kontrollera att antalet kort att dra är giltigt
        if ($number > 52) {
            throw new Exception("Can not draw more cards than the number of cards a deck contains");
        } elseif ($number > $deck->countDeck()) {
            throw new Exception("Can not draw more cards than cards left in deck.");
        }

        $hand = new CardHand();

        for ($i = 1; $i <= $number; $i++) {
            $drawnCard = $deck->draw();

            // Lägg till det dragna kortet till handen
            if ($drawnCard !== null) {
                $hand->add($drawnCard);
            } else {
                break; // Om kortleken är tom, bryt loopen
            }
        }

        // Spara handen i sessionen
        $session->set("drawn_cards", $hand->getHand());

        // Uppdatera kortleken i sessionen
        $session->set("cards_left_in_deck", $deck);

        // Hämta kortleken som en array av kortrepresentationer
        $deckLeft = [];
        foreach ($deck->getDeck() as $card) {
            $deckLeft[] = $card->representCard();
        }

        $deckDrawn = [];
        foreach ($hand->getHand() as $card) {
            $deckDrawn[] = $card->representCard();
        }

        $deckLeftInt = $deck->countDeck();

        // Returnerar information om dragna kort och kort kvar i leken som JSON
        $data = [
            "cardsLeftInt" => $deckLeftInt,
            "cardsDrawn" => $deckDrawn,
            "cardsLeft" => $deckLeft,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
