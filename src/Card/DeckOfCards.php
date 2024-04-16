<?php

namespace App\Card;


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

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    // Draw a card from the deck
    public function draw(): ?Card
    {
        // If the deck is empty, return null
        if (empty($this->deck)) {
            return null;
        }

        // Slumpmässigt välj en nyckel från kortleken
        $randomKey = array_rand($this->deck);

        // Hämta det slumpmässigt valda kortet från kortleken
        $drawnCard = $this->deck[$randomKey];

        // Ta bort det dragna kortet från kortleken
        unset($this->deck[$randomKey]);

        // Återställ index för att undvika luckor i arrayen
        $this->deck = array_values($this->deck);

        // Returnera det dragna kortet
        return $drawnCard;
    }

    // // Sort cards
    // public function sort(): void
    // {
    //     usort($this->deck, function ($a, $b) {
    //         if ($a->getValue() == $b->getValue()) {
    //             return $a->getSuit() - $b->getSuit(); // Sortera efter färg om värdena är lika
    //         }
    //         return $a->getValue() - $b->getValue(); // Sortera efter värde
    //     });
    // }
}