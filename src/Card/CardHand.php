<?php
namespace App\Card;

use App\Card\Card;

class CardHand 
{
    private array $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }


    public function countHand(): int
    {
        return count($this->hand);
    }


    public function getHand(): array
    {
        return $this->hand;
    }
}