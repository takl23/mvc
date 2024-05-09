<?php

namespace App\Controller;

// use App\Card\Card;
// use App\Card\DeckOfCards;
// use App\Card\CardHand;

use App\Card\Game21;


// use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Exception;

class Game21Controller extends AbstractController
{
    #[Route("/game", name: "game21_start", methods: ["GET"])]
    public function home(): Response
    {
        
        return $this->render('game/home.html.twig');
    }

    #[Route("/game/doc", name: "game21_documentation", methods: ["GET"])]
    public function doc(): Response
    {
        
        return $this->render('game/doc.html.twig');
    }

    #[Route("/game/init21", name: "init21", methods: ["POST"])]
    public function init21(SessionInterface $session): Response
    {
        $game21 = new Game21();
        $game21->NewGame();

        $session->set("game21", $game21);
    
        // $player1Cards = $game21->getPlayer1Hand()->getHand();
        // $player2Cards = $21->getPlayer2Hand()->getHand();
    
        return $this->redirectToRoute('play21');
    }
     
    #[Route("/game/play21", name: "play21", methods: ["GET"])]
    public function play21(SessionInterface $session): Response
    {
        $game21 = $session->get("game21");

        if ($game21 == null) {
            return $this->redirectToRoute('init21');
        }
    
        $player1Hand = $game21->getPlayer1Hand()->getHand();
        $player1Score = $game21->sumHand($player1Hand);

        $player2Hand = $game21->getPlayer2Hand()->getHand();
    
        return $this->render('game/play21.html.twig', [
            'player1Hand' => $player1Hand,
            'player1Score' => $player1Score,

            'player2Hand' => $player2Hand,
        ]);
        
    }

    #[Route("/game/draw21", name: "draw21", methods: ["POST"])]
    public function draw21(SessionInterface $session): Response
    {
        $game21 = $session->get("game21");
        $deck = $game21->getDeck();
        $player1Hand = $game21->getPlayer1Hand();

        $card = $deck->draw();
        $player1Hand ->add($card);

        if ($game21 == null) {
            return $this->redirectToRoute('init21');
        }
    
        return $this->redirectToRoute('play21');

    }
}
