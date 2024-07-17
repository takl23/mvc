<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Game21 extends AbstractController
{
    // Egenskaper för att hantera kortleken och spelarnas händer
    private DeckOfCards $deck;
    private CardHand $player1Hand;
    private CardHand $player2Hand;

    /**
     * Constructor för Game21
     * Skapar en ny kortlek och tomma händer för spelarna
     */
    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->player1Hand = new CardHand();
        $this->player2Hand = new CardHand();
    }

    /**
     * Initierar ett nytt spel genom att blanda kortleken och tömma spelarnas händer
     */
    public function newGame(): void
    {
        $this->deck->shuffle();
        $this->player1Hand = new CardHand();
        $this->player2Hand = new CardHand();
    }

    /**
     * Drar ett kort till spelare 1:s hand från kortleken
     */
    public function drawCardPlayer1(): void
    {
        // Hämta ett kort från leken
        $newCard = $this->deck->draw();

        // Kontrollera om det hämtade kortet är en giltig instans av Card innan du lägger till det i handen
        if ($newCard instanceof Card) {
            $this->player1Hand->add($newCard);
        }
    }

    /**
     * Drar ett kort till spelare 2:s hand från kortleken
     */
    public function drawCardPlayer2(): void
    {
        // Hämta ett kort från leken
        $newCard = $this->deck->draw();

        // Kontrollera om det hämtade kortet är en giltig instans av Card innan du lägger till det i handen
        if ($newCard instanceof Card) {
            $this->player2Hand->add($newCard);
        }
    }

    /**
     * Hämtar spelare 1:s hand
     *
     * @return CardHand Spelare 1:s hand
     */
    public function getPlayer1Hand(): CardHand
    {
        return $this->player1Hand;
    }

    /**
     * Hämtar spelare 2:s hand
     *
     * @return CardHand Spelare 2:s hand
     */
    public function getPlayer2Hand(): CardHand
    {
        return $this->player2Hand;
    }

    /**
     * Hämtar poängen för spelare 1:s hand
     *
     * @return int Poängen för spelare 1:s hand
     */
    public function getPlayer1Score(): int
    {
        return $this->sumHand($this->player1Hand->getHand());
    }

    /**
     * Hämtar poängen för spelare 2:s hand
     *
     * @return int Poängen för spelare 2:s hand
     */
    public function getPlayer2Score(): int
    {
        return $this->sumHand($this->player2Hand->getHand());
    }

    /**
     * Hämtar kortleken
     *
     * @return DeckOfCards Kortleken
     */
    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }

   /**
 * Räknar summan av värden för kort i handen.
 *
 * @param Card[] $hand En array som innehåller Card-objekt som representerar handen.
 * @return int Summan av värden för kort i handen.
 */
public function sumHand(array $hand): int
{
    return array_reduce($hand, function($sum, $card) {
        return $sum + $card->getValue();
    }, 0);
}

  /**
 * Processar resultatet av spelet och bestämmer vinnaren
 *
 * @return string En sträng som beskriver resultatet av spelet
 */
public function processResult(): string
{
    $player1Score = $this->getPlayer1Score();
    $player2Score = $this->getPlayer2Score();

    // Kontrollera om båda spelarna förlorar
    if ($player1Score > 21 && $player2Score > 21) {
        return "Ingen vinner, båda förlorar";
    }

    // Kontrollera om spelare 1 förlorar
    if ($player1Score > 21) {
        return "Spelare 2 vinner, spelare 1 förlorar";
    }

    // Kontrollera om spelare 2 förlorar
    if ($player2Score > 21) {
        return "Spelare 1 vinner, spelare 2 förlorar";
    }

    // Kontrollera vem som har högst poäng
    if ($player1Score > $player2Score) {
        return "Spelare 1 vinner!";
    }

    if ($player2Score > $player1Score) {
        return "Spelare 2 vinner!";
    }

    // Om poängen är lika, är det oavgjort
    return "Det är oavgjort!";
    }
}
