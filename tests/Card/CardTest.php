<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Exception;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use valid arguments for card creation.
     */
    public function testCreateCard(): void
    {
        $card = new Card(Card::KING, Card::HEARTS);
        $this->assertInstanceOf("\App\Card\Card", $card);

        $res = $card->representCard();
        $this->assertEquals('K ♥', $res);

    }

    /**
     * Test to create a card with invalid value
     */
    public function testInvalidCardValue(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Value must be between 1 and 13.");
        new Card(0, Card::HEARTS);
    }

    /**
     * Test to create a card with invalid suit
     */
    public function testInvalidCardSuit(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Invalid suit.");
        new Card(1, 5);
    }

    /**
     * Test color of a card
     */
    public function testCardColor(): void
    {
        $card = new Card(Card::KING, Card::HEARTS);
        $this->assertInstanceOf("\App\Card\Card", $card);
        $this->assertEquals('red', $card->getColor());
    }

}
