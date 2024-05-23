<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Exception;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Create a hand and verify that the hand is an array 
     */
    public function testCardHand(): void
    {
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand); 
        $this->assertCount(0, $cardHand->getHand());
        $this->assertEquals(0, $cardHand->countHand());

        $card = new Card(Card::KING, Card::HEARTS);
        $this->assertInstanceOf("\App\Card\Card", $card);

        $cardHand-> add($card);
        $this->assertCount(1, $cardHand->getHand());
        $this->assertEquals(1, $cardHand->countHand());

       
    }        
}