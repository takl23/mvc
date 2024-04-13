<?php

namespace App\Card;

//use function PHPUnit\Framework\stringContains;
use InvalidArgumentException;

class DeckOfCards
{
    private array $deck; //deck of cards
    
    public function __construct()
    {
        $this->deck = [];

        // Loop through each suit and value to create the deck
        //  I Card är detta definerat som HEARTS = 1, DIAMONDS = 2, CLUBS = 3, SPADES = 4;
        for ($suit = Card::HEARTS; $suit <= Card::SPADES; $suit++) {
            for ($value = Card::ACE; $value <= Card::KING; $value++) {
                $this->deck[] = new Card($value, $suit);
            }
        }
    }

    // Getter method to retrieve the deck
    public function getDeck(): array
    {
        return $this->deck;
    }

}