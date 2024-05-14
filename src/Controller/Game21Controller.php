<?php

namespace App\Controller;

use App\Card\Card;
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
        $game21->newGame();

        $session->set("game21", $game21);

        return $this->redirectToRoute('play21');
    }

    #[Route("/game/play21", name: "play21", methods: ["GET"])]
    public function play21(SessionInterface $session): Response
    {
        /** @var Game21|null $game21 */
        $game21 = $session->get("game21");

        if ($game21 == null) {
            return $this->redirectToRoute('init21');
        }

        $player1Hand = $game21->getPlayer1Hand()->getHand();
        $player1Score = $game21->sumHand($player1Hand);

        $player2Hand = $game21->getPlayer2Hand()->getHand();
        $player2Score = $game21->sumHand($player2Hand);

        // sätt ställning i sessionen
        $session->set("player1Score", $player1Score);
        $session->set("player2Score", $player2Score);

        return $this->render('game/play21.html.twig', [
            'player1Hand' => $player1Hand,
            'player1Score' => $player1Score,
            'player2Hand' => $player2Hand,
            'player2Score' => $player2Score,
        ]);

    }

    #[Route("/game/result21", name: "result21", methods: ["GET", "POST"])]
    public function result21(SessionInterface $session): Response
    {
        /** @var Game21|null $game21 */
        $game21 = $session->get("game21");

        // Kontrollera om $game21 är null innan du fortsätter
        if ($game21 == null) {
            return $this->redirectToRoute('init21');
        }

        $player1Hand = $game21->getPlayer1Hand()->getHand();
        $player1Score = $game21->sumHand($player1Hand);

        $player2Hand = $game21->getPlayer2Hand()->getHand();
        $player2Score = $game21->sumHand($player2Hand);

        // sätt ställning i sessionen
        $session->set("player1Score", $player1Score);
        $session->set("player2Score", $player2Score);

        return $this->render('game/result21.html.twig', [
            'player1Hand' => $player1Hand,
            'player1Score' => $player1Score,
            'player2Hand' => $player2Hand,
            'player2Score' => $player2Score,
        ]);

    }

    #[Route("/game/draw21", name: "draw21", methods: ["POST"])]
    public function draw21(SessionInterface $session): Response
    {
        /** @var Game21|null $game21 */
        $game21 = $session->get("game21");

        if ($game21 == null) {
            return $this->redirectToRoute('init21');
        }

        $deck = $game21->getDeck();
        $player1Hand = $game21->getPlayer1Hand();

        $card = $deck->draw();

        if ($card instanceof Card) {
            $player1Hand ->add($card);
        }

        // Omdirigera om spelare 1 når >21
        if ($game21->getPlayer1Score() > 21) {
            return $this->redirectToRoute('stay21');
        }

        return $this->redirectToRoute('play21');

    }

    #[Route("/game/stay21", name: "stay21", methods: ["GET", "POST"])]
    public function stay21(SessionInterface $session): Response
    {
        /** @var Game21|null $game21 */
        $game21 = $session->get("game21");


        if ($game21 == null) {
            return $this->redirectToRoute('init21');
        }

        // Dra kort för spelare 2 tills deras poäng når 17 eller mer
        while ($game21->getPlayer2Score() < 17) {
            $game21->drawCardPlayer2();
        }

        // Beräkna vinnaren baserat på spelarnas poäng
        $result = $game21->processResult();
        // Använd flashmeddelanden för att skicka meddelandet till nästa request
        $this->addFlash('info', $result);

        // Uppdatera spelet i sessionen
        $session->set("game21", $game21);

        // Omdirigera till resultatet
        return $this->redirectToRoute('result21');
    }
}
