<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;

class Game21

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

        // //Deal inital cards player 1 and 2
        $this->player1Hand->add($this->deck->draw());
        // $this->player2Hand->add($this->deck->draw());
    }

    public function getPlayer1Hand(): CardHand
    {
        return $this->player1Hand;
    }

    public function getPlayer2Hand(): CardHand
    {
        return $this->player2Hand;
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

}
