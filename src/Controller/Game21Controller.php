<?php

namespace App\Controller;

// use App\Card\Card;
// use App\Card\DeckOfCards;
// use App\Card\CardHand;

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

     
}
