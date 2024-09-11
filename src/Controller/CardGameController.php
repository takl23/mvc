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
    #[Route("/game/card/init", name: "card_init", methods: ["GET"])]
    public function initcallback(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set("cards_left_in_deck", $deck);
        return $this->redirectToRoute('card_start');
    }

    #[Route("/game/card", name: "card_start", methods: ["GET"])]
    public function home(SessionInterface $session): Response
    {
        $deck = $session->get("cards_left_in_deck");
        if (!$deck instanceof DeckOfCards) {
            return $this->redirectToRoute('card_init');
        }

        $data = [
            "deck" => $deck->getDeck()
        ];

        return $this->render('card/home.html.twig', $data);
    }

    #[Route("/game/card/card", name: "testcard")]
    public function testCard(LoggerInterface $logger): Response
    {
        $value = random_int(1, 13);
        $suit = random_int(1, 4);
        $cardGraphic = new CardGraphic($value, $suit);
        $card = new Card($value, $suit);

        $logger->info("Value: $value, Suit: $suit");

        $data = [
            "cardGraphic" => $cardGraphic->representCardUnicode(),
            "card" => $card->representCard(),
        ];

        return $this->render('card/card.html.twig', $data);
    }

    #[Route("/game/card/deck", name: "deck", methods: ["GET"])]
    public function sortedDeck(SessionInterface $session): Response
    {
        $deck = $session->get("cards_left_in_deck");

        if (!$deck instanceof DeckOfCards) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set("cards_left_in_deck", $deck);
        }

        $data = [
            "deck" => $deck->getDeckOfCardGraphics(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/game/card/deck/shuffle", name: "deck_shuffle", methods: ["GET"])]
    public function shuffleDeck(SessionInterface $session): Response
    {
        $deck = $session->get("cards_left_in_deck");

        if (!$deck instanceof DeckOfCards) {
            return new Response("Deck is not available.", Response::HTTP_BAD_REQUEST);
        }

        $shuffleDeck = $deck->getDeck();
        shuffle($shuffleDeck);

        $data = [
            "deck" => $shuffleDeck
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/game/card/deck/draw", name: "deck_draw", methods: ["GET"])]
    public function drawOneCard(SessionInterface $session): Response
    {
        $deck = $session->get("cards_left_in_deck");
        if (!$deck instanceof DeckOfCards) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set("cards_left_in_deck", $deck);
        }

        $hand = new CardHand();
        $hand->drawCard($deck); // Använd instansmetoden som kallar den statiska metoden

        $data = [
            "cardsLeft" => $deck->getDeck(),
            "cardsDrawn" => $hand->getHand(),
            "cardsLeftInt" => $deck->countDeck(),
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/game/card/deck/draw/{number<\d+>}", name: "draw_5_cards", methods: ["GET"])]
    public function drawFiveCards(SessionInterface $session, int $number): Response
    {
        $deck = $session->get("cards_left_in_deck");
        if (!$deck instanceof DeckOfCards) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set("cards_left_in_deck", $deck);
        }

        if ($number > 52) {
            throw new Exception("Can not draw more cards than the number of cards a deck contains");
        } elseif ($number > $deck->countDeck()) {
            throw new Exception("Can not draw more cards than cards left in deck.");
        }

        $hand = new CardHand();
        for ($i = 1; $i <= $number; $i++) {
            $hand->drawCard($deck); // Använd instansmetoden som kallar den statiska metoden
        }

        $session->set("drawn_cards", $hand);

        $data = [
            "cardsLeft" => $deck->getDeck(),
            "cardsDrawn" => $hand->getHand(),
            "cardsLeftInt" => $deck->countDeck(),
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/game/card/session", name: "card_session", methods: ['GET'])]
    public function sessionPrint(SessionInterface $session): Response
    {
        $data = [
            "session" => $session->all()
        ];

        return $this->render('card/session.html.twig', $data);
    }

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
