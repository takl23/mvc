<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CardGameController extends AbstractController
{
    #[Route("/game/card", name: "card_start")]
    public function home(): Response
    {
            return $this->render('card/home.html.twig');
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
        
            return $this->redirectToRoute('card_session');
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

    #[Route("/game/card/deck", name: "deck")]
    public function deck(): Response
    {
            return $this->render('card/deck.html.twig');
    }

}
