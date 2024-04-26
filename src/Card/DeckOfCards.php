<?php

namespace App\Card;


class DeckOfCards 
{
    private array $deck; //deck of cards
    
    public function __construct()
    {
        $this->deck = [];

        // Loop through each suit and value to create the deck
        //  In Card this is defined as HEARTS = 1, DIAMONDS = 2, CLUBS = 3, SPADES = 4;
        for ($suit = CardGraphic::HEARTS; $suit <= CardGraphic::SPADES; $suit++) {
            for ($value = CardGraphic::ACE; $value <= CardGraphic::KING; $value++) {
                $this->deck[] = new CardGraphic($value, $suit);
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
    public function draw(): ?CardGraphic
    {
        // If the deck is empty, return null
        if (empty($this->deck)) {
            return null;
        }

        $randomKey = array_rand($this->deck);

        $drawnCard = $this->deck[$randomKey];

        unset($this->deck[$randomKey]);

        $this->deck = array_values($this->deck);

        return $drawnCard;
    }

    public function countDeck(): int
    {
        return count($this->deck);
    }

    public function getDeckOfCardGraphics(): array
{
    $cardGraphics = [];

    foreach ($this->deck as $card) {
        $cardGraphics[] = new CardGraphic($card->getValue(), $card->getSuit());
    }

    return $cardGraphics;
}

}