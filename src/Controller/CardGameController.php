<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Card\CardGraphic;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class CardGameController extends AbstractController
{
    // Initierar en ny kortlek och sparar den i sessionen
    #[Route("/game/card/init", name: "card_init", methods: ["GET"])]
    public function initcallback(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $session->set("cards_left_in_deck", $deck);
        return $this->redirectToRoute('card_start');
    }

    // Startar spelet och visar kortleken
    #[Route("/game/card", name: "card_start", methods: ["GET"])]
    public function home(SessionInterface $session): Response
    {
        /** @var DeckOfCards|null $deck */
        $deck = $session->get("cards_left_in_deck");
        if ($deck == null) {
            return $this->redirectToRoute('card_init');
        }
        $data = [
            "deck" => $deck->getDeck()
        ];
        $session->set("cards_left_in_deck", $deck);

        return $this->render('card/home.html.twig', $data);
    }

    // Testar att skapa och visa ett kort
    #[Route("/game/card/card", name: "testcard")]
    public function testCard(LoggerInterface $logger): Response
    {
        $value = random_int(1, 13);
        $suit = random_int(1, 4);
        $cardGraphic = new CardGraphic($value, $suit);
        $card = new Card($value, $suit);

        // Logga kortets värde och svit
        $logger->info("Value: $value, Suit: $suit");

        $data = [
            "cardGraphic" => $cardGraphic->representCardUnicode(),
            "card" => $card->representCard(),
        ];

        return $this->render('card/card.html.twig', $data);
    }

    // Visar den aktuella kortleken
    #[Route("/game/card/deck", name: "deck", methods: ["GET"])]
    public function sortedDeck(SessionInterface $session): Response
    {
        /** @var DeckOfCards|null $deck */
        $deck = $session->get("cards_left_in_deck");

        // Om det inte finns någon kortlek i sessionen, skapa en ny och blanda den
        if ($deck === null) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set("cards_left_in_deck", $deck);
        }

        $data = [
            "deck" => $deck->getDeckOfCardGraphics(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    // Blandar kortleken och visar den
    #[Route("/game/card/deck/shuffle", name: "deck_shuffle", methods: ["GET"])]
    public function shuffleDeck(SessionInterface $session): Response
    {
        /** @var DeckOfCards|null $deck */
        $deck = $session->get("cards_left_in_deck");

        // Kontrollera om det finns en kortlek i sessionen
        if ($deck === null) {
            return new Response("Deck is not available.", Response::HTTP_BAD_REQUEST);
        }

        // Kopiera och blanda kortleken
        $shuffleDeck = $deck->getDeck();
        shuffle($shuffleDeck);

        $data = [
            "deck" => $shuffleDeck
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    // Drar ett kort från kortleken och visar det
    #[Route("/game/card/deck/draw", name: "deck_draw", methods: ["GET"])]
    public function drawOneCard(SessionInterface $session): Response
    {
        /** @var DeckOfCards|null $deck */
        $deck = $session->get("cards_left_in_deck");

        // Om det inte finns någon kortlek, skapa en ny och blanda den
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

        $data = [
            "cardsLeft" => $deck->getDeck(),
            "cardsDrawn" => $hand->getHand(),
            "cardsLeftInt" => $deck->countDeck(),
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    // Drar ett specifikt antal kort från kortleken och visar dem
    #[Route("/game/card/deck/draw/{number<\d+>}", name: "draw_5_cards", methods: ["GET"])]
    public function drawFiveCards(SessionInterface $session, int $number): Response
    {
        /** @var DeckOfCards|null $deck */
        $deck = $session->get("cards_left_in_deck");

        // Om det inte finns någon kortlek, skapa en ny och blanda den
        if ($deck === null) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set("cards_left_in_deck", $deck);
        }

        // Kontrollera att kortleken är en instans av DeckOfCards
        if (!($deck instanceof DeckOfCards)) {
            throw new Exception("Invalid deck.");
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

            // Kontrollera om det dragna kortet är en instans av Card innan du lägger till det i handen
            if ($drawnCard instanceof Card) {
                $hand->add($drawnCard);
            } else {
                throw new Exception('Invalid card drawn from the deck.');
            }
        }

        // Spara handen i sessionen
        $session->set("drawn_cards", $hand);

        $data = [
            "cardsLeft" => $deck->getDeck(),
            "cardsDrawn" => $hand->getHand(),
            "cardsLeftInt" => $deck->countDeck(),
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    // Visar sessionens innehåll
    #[Route("/game/card/session", name: "card_session", methods: ['GET'])]
    public function sessionPrint(SessionInterface $session): Response
    {
        $data = [
            "session" => $session->all()
        ];

        return $this->render('card/session.html.twig', $data);
    }

    // Rensar sessionen och visar ett meddelande
    #[Route("/game/card/session/delete", name: "card_session_delete", methods: ["GET"])]
    public function sessionDelete(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash(
            'notice',
            'Session deleted!'
        );

        return $this->redirectToRoute('card_start');
    }

    // Rensar sessionen med POST-metod och visar ett meddelande
    #[Route("/game/card/session/delete2", name: "card_session_delete2", methods: ['POST'])]
    public function sessionDelete2(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash(
            'notice',
            'Session deleted!'
        );

        return $this->redirectToRoute('card_session');
    }
}
