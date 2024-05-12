<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Game21 extends AbstractController

{
    // FUNKTIONER
    // •	Skapa kortlek och blanda - från DeckOfCards
    // •	Skapa hand för spelare och banken - från CardHand
    // •	Dra kort och lägga in i hand - från CardHand
    // •	Summera handen - Använd getValue i klassen Card och utveckla 
    // •	Resultatet - Skapa logik för vem som vinner - (Kanske egen klass?)

    private DeckOfCards $deck;
    private CardHand $player1Hand;
    private CardHand $player2Hand;

    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->player1Hand = new CardHand();
        $this->player2Hand = new CardHand();
    }

    public function NewGame(): void
    {
        $this->deck->shuffle();
        $this->player1Hand = new CardHand();
        $this->player2Hand = new CardHand();

        $this->player1Hand->add($this->deck->draw());
        
    }


    public function drawCardPlayer2(): void
    {
        $this->player2Hand->add($this->deck->draw());
    }



    public function getPlayer1Hand(): CardHand
    {
        return $this->player1Hand;
    }

    public function getPlayer2Hand(): CardHand
    {
        return $this->player2Hand;
    }

    public function getPlayer1Score(): int
    {
    return $this->sumHand($this->player1Hand->getHand());
    }

    public function getPlayer2Score(): int
    {
        return $this->sumHand($this->player2Hand->getHand());
    }

    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }

    public function sumHand(array $hand): int
    {
        $sum = 0;

        foreach ($hand as $card) {
            $sum += $card->getValue();
        }

        return $sum;
    }

    public function processResult(): string
{
    $player1Score = $this->getPlayer1Score();
    $player2Score = $this->getPlayer2Score();

    if ($player1Score > 21 && $player2Score > 21) {
        $result = "Ingen vinner, båda förlorar";
    } elseif ($player1Score > 21) {
        $result = "Spelare 2 vinner, spelare 1 förlorar";
    } elseif ($player2Score > 21) {
        $result = "Spelare 1 vinner, spelare 2 förlorar";
    } elseif ($player1Score > $player2Score) {
        $result = "Spelare 1 vinner!";
    } elseif ($player2Score > $player1Score) {
        $result = "Spelare 2 vinner!";
    } else {
        $result = "Det är oavgjort!";
    }

    return $result;

}

}