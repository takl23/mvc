<?php

namespace App\Card;

use Exception;

class CardHand
{
    /**
     * @var Card[]
     */
    private array $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function countHand(): int
    {
        return count($this->hand);
    }

    /**
    * @return Card[]
    */
    public function getHand(): array
    {
        return $this->hand;
    }

    /**
     * Hjälpfunktion för att dra ett kort och lägga till det i en hand.
     */
    public static function drawCardToHand(DeckOfCards $deck, CardHand $hand): void
    {
        $drawnCard = $deck->draw();

        if ($drawnCard === null) {
            throw new Exception("The deck is empty!");
        }

        $hand->add($drawnCard);
    }

    /**
     * Wrapper instansmetod för att dra ett kort.
     */
    public function drawCard(DeckOfCards $deck): void
    {
        self::drawCardToHand($deck, $this);
    }
}
