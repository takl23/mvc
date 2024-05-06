<?php

namespace App\Controller;

// use App\Card\Card;
// use App\Card\DeckOfCards;
// use App\Card\CardHand;

use App\Card\Game21;


// use Psr\Log\LoggerInterface;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

    #[Route("/game/play21", name: "game21_play", methods: ["GET"])]
    public function play21(): Response
    {
        $game = new Game21();
        $game->NewGame();
    
        $player1Cards = $game->getPlayer1Hand()->getHand();
        $player2Cards = $game->getPlayer2Hand()->getHand();
    
        return $this->render('game/play21.html.twig', [
            'player1Cards' => $player1Cards,
            'player2Cards' => $player2Cards,
        ]);
        
        return $this->render('game/play21.html.twig');
    }
     
}
