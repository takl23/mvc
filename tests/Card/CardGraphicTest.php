<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Exception;

/**
 * Test cases for class CardHand.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Test to get graphic representation of card
     */
    public function testGraphicRep(): void
    {
        $card = new CardGraphic(Card::ACE, Card::HEARTS);
        $this->assertInstanceOf("\App\Card\CardGraphic", $card); 
        $this->assertEquals("\u{1F0B1}", $card->getgraphicRep());          
    }   

    /**
     * Test to get graphic representation of card
     */
    public function testGraphicRepConvertToString(): void
    {
        $card = new CardGraphic(Card::ACE, Card::HEARTS);
        $this->assertInstanceOf("\App\Card\CardGraphic", $card); 
        $this->assertEquals("\u{1F0B1}", (string)$card);          
    }        
}   
