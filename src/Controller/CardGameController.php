<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\DeckOfCards;
use App\Card\CardHand;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Exception;

class CardGameController extends AbstractController
{
    #[Route("/game/card/init", name: "card_init")]
    public function initcallback(SessionInterface $session): Response 
    {
        $deck = new DeckOfCards();
        $session->set("cards_left_in_deck", $deck);
        return $this->redirectToRoute('card_start');
    }

    #[Route("/game/card", name: "card_start")]
    public function home(SessionInterface $session): Response
    {
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

    #[Route("/game/card/test/card", name: "test_card")]
    public function testCard(): Response
    {
        $card = new Card(random_int(1, 13), random_int(1, 4));

        $data = [
            "card" => $card->representCard(),
        ];

        return $this->render('card/test/card.html.twig', $data);
    }

    #[Route("/game/card/test/deck", name: "test_deck")]
    public function sortedDeck(SessionInterface $session): Response
    {
        $deck = $session->get("cards_left_in_deck");

        $data = [
            "deck" => $deck->getDeck(),
        ];

        $session->set("cards_left_in_deck", $deck);

        return $this->render('card/test/deck.html.twig', $data);
    }

    #[Route("/game/card/test/deck/shuffle", name: "test_deck_shuffle")]
    public function shuffleDeck(SessionInterface $session): Response
    {
    $deck = $session->get("cards_left_in_deck");

    // Make copy of deck
    $shuffleDeck = $deck->getDeck();

   shuffle($shuffleDeck);

    $data = [
        "deck" => $shuffleDeck
    ];

    return $this->render('card/test/deck.html.twig', $data);
    }

    #[Route("/game/card/test/deck/draw", name: "test_deck_draw")]
    public function drawCard(SessionInterface $session): Response
    {
        $deck = $session->get("cards_left_in_deck");

        if ($deck === null) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set("cards_left_in_deck", $deck);
        }

        // if ($deck->getNumberCards() <= 0) {
        //     throw new Exception("Can't draw more cards than the deck currently contains.");
        // }

        $hand = new CardHand();
        $drawnCard = $deck->draw();

        // Om det inte finns några kort kvar i kortleken, visa ett meddelande
        if ($drawnCard === null) {
        return new Response("The deck is empty!");
        }
        
        $hand->add($drawnCard);

        //$deck->sort();

        $data = [
            "cardsLeft" => $deck->getDeck(),
            "cardsDrawn" => $drawnCard,
        ];

        return $this->render('card/test/drawone.html.twig', $data);
    }

    #[Route("/game/card/session", name: "card_session", methods: ['GET'])]
    public function sessionPrint(
        SessionInterface $session
    ): Response
    {
       
        $data = [
            "session" => $session->all()
        ];

        //var_dump($data);
        

            return $this->render('card/session.html.twig', $data);
    }

    #[Route("/game/card/session/delete", name: "card_session_delete")]
    public function sessionDelete(
        SessionInterface $session
    ): Response
    {
      
    $session->clear();
    

$this->addFlash(
            'notice',
            'Session deleted!'
        );
        //var_dump($data);
        
            return $this->redirectToRoute('card_start');
    }

  

    #[Route("/game/card/session/delete2", name: "card_session_delete2", methods: ['POST'])]
    public function sessionDelete2(
        SessionInterface $session
    ): Response
    {
      
    $session->clear();
    

$this->addFlash(
            'notice',
            'Session deleted!'
        );
        //var_dump($data);
        
            return $this->redirectToRoute('card_session');
    }
}