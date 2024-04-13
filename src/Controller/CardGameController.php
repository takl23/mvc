<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\DeckOfCards;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/game/card", name: "card_start")]
    public function home(): Response
    {
            return $this->render('card/home.html.twig');
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
    public function testDeck(): Response
    {
        $deck = new DeckOfCards();

        $data = [
            "deck" => $deck->getDeck(),
        ];

        return $this->render('card/test/deck.html.twig', $data);
    }

    // #[Route("/game/card/test/dicehand/{num<\d+>}", name: "test_dicehand")]
    // public function testDiceHand(int $num): Response
    // {
    //     if ($num > 52) {
    //         throw new \Exception("Can not roll more than 52 dices!");
    //     }

    //     $hand = new DiceHand();
    //     for ($i = 1; $i <= $num; $i++) {
    //         $hand->add(new Dice());
    //     }

    //     $hand->drawCard();

    //     $data = [
    //         "num_dices" => $hand->getNumberDices(),
    //         "diceRoll" => $hand->getString(),
    //     ];

    //     return $this->render('card/test/dicehand.html.twig', $data);
    // }

}
