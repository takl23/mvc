<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Exception;

/**
 * Test cases for class DeckOfCards.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Create a deck and verify that the deck is containing 52 cards
     */
    public function testCreateDeck(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        //$this->assertEquals(52, $deck->getDeck());
        $this->assertCount(52, $deck->getDeck());
    }

    /**
    * Test to shuffle deck
    */
    public function testShuffleDeck(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        $originalDeck = $deck->getDeck();
        $deck->shuffle();
        $shuffledDeck = $deck->getDeck();

        $this->assertNotEquals($originalDeck, $shuffledDeck);
        $this->assertCount(52, $shuffledDeck);
    }

    /**
    * Test to draw one card from deck
    */
    public function testDrawCard(): void
    {
        $deck = new DeckOfCards();
        $deck->draw();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        $this->assertCount(51, $deck->getDeck());
    }

    /**
    * Test to count deck
    */
    public function testCountDeck(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        $countDeck = $deck->countDeck();
        $this->assertEquals(52, $countDeck);
    }

    /**
    * Test graphic representation of deck
    */
    public function testGraphiccDeck(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        $deckGraphic = $deck -> getDeckOfCardGraphics();
        $this->assertCount(52, $deckGraphic);
    }

    /**
    * Test to draw cards if deck is emphy
    */
    public function testDrawEmphtyDeck(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        for ($i = 0; $i < 52; $i++) {
            $deck->draw();
        }

        $drawnCard = $deck->draw();
        $this->assertNull($drawnCard);
    }

}
