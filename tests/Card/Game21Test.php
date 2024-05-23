<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Exception;

/**
 * Test cases for class Card.
 */
class Game21Test extends TestCase
{
    /**
     * Construct object and verify that the object is correctly instansiated
     */
    public function testSetupGameInitaialValues()
    {
        $game21 = new Game21();
        $this->assertInstanceOf("\App\Card\Game21", $game21);

        $this->assertInstanceOf("\App\Card\DeckOfCards", $game21->getDeck());
        $this->assertInstanceOf("\App\Card\CardHand", $game21->getPlayer1Hand());
        $this->assertInstanceOf("\App\Card\CardHand", $game21->getPlayer2Hand());
    }

    /**
     * Test creating a new game
     */
    public function testNewGame()
    {
        $game21 = new Game21();
        $this->assertInstanceOf("\App\Card\Game21", $game21);

        $game21 -> newGame();

        $this->assertInstanceOf("\App\Card\DeckOfCards", $game21->getDeck());

        $this->assertCount(0, $game21->getPlayer1Hand()->getHand());
        $this->assertCount(0, $game21->getPlayer2Hand()->getHand());
    }

    /**
     * Test creating a new game
     */
    public function testdrawCard()
    {
        $game21 = new Game21();
        $this->assertInstanceOf("\App\Card\Game21", $game21);

        $game21 -> newGame();
        
        $game21->drawCardPlayer1();
        $this->assertCount(1, $game21->getPlayer1Hand()->getHand());

        $game21->drawCardPlayer2();
        $this->assertCount(1, $game21->getPlayer2Hand()->getHand());

    }

    /**
     * Test sum a hand
     */
    public function testSumHand()
    {
        $game21 = new Game21();
        $this->assertInstanceOf("\App\Card\Game21", $game21);

        $game21 -> newGame();
        $game21->drawCardPlayer1();
        $player1Score = $game21->getPlayer1Score();
        $compareValue = 0;     

        $this->assertGreaterThan($compareValue,  $player1Score);

        $game21->drawCardPlayer2();
        $player2Score = $game21->getPlayer2Score();
        $this->assertGreaterThan($compareValue,  $player2Score);

    }



/**
 * Test processResult by adding known values to players hands and compare expression
 */
public function testProcessResult()
{
    $game21 = new Game21();
    $this->assertInstanceOf("\App\Card\Game21", $game21);

    $game21 -> newGame();
    $game21->getPlayer1Hand()->add(new Card(10, Card::HEARTS));
    $game21->getPlayer1Hand()->add(new Card(11, Card::HEARTS));
    $game21->getPlayer1Hand()->add(new Card(12, Card::HEARTS));
    $game21->getPlayer2Hand()->add(new Card(10, Card::SPADES));
    $game21->getPlayer2Hand()->add(new Card(11, Card::SPADES));
    $game21->getPlayer2Hand()->add(new Card(12, Card::SPADES));
    $this->assertEquals("Ingen vinner, båda förlorar", $game21->processResult());


    $game21 -> newGame();
    $game21->getPlayer1Hand()->add(new Card(10, Card::HEARTS));
    $game21->getPlayer1Hand()->add(new Card(11, Card::HEARTS));
    $game21->getPlayer1Hand()->add(new Card(12, Card::HEARTS));
    $game21->getPlayer2Hand()->add(new Card(10, Card::SPADES));
    $game21->getPlayer2Hand()->add(new Card(11, Card::SPADES));
 
    $this->assertEquals("Spelare 2 vinner, spelare 1 förlorar", $game21->processResult());


    $game21 -> newGame();
    $game21->getPlayer1Hand()->add(new Card(10, Card::HEARTS));
    $game21->getPlayer1Hand()->add(new Card(11, Card::HEARTS));
    $game21->getPlayer2Hand()->add(new Card(10, Card::SPADES));
    $game21->getPlayer2Hand()->add(new Card(11, Card::SPADES));
    $game21->getPlayer2Hand()->add(new Card(12, Card::SPADES));
    $this->assertEquals( "Spelare 1 vinner, spelare 2 förlorar", $game21->processResult());


    $game21 -> newGame();
    $game21->getPlayer1Hand()->add(new Card(10, Card::HEARTS));
    $game21->getPlayer2Hand()->add(new Card(5, Card::SPADES));
    $this->assertEquals("Spelare 1 vinner!", $game21->processResult());

    $game21 -> newGame();
    $game21->getPlayer1Hand()->add(new Card(2, Card::HEARTS));
    $game21->getPlayer2Hand()->add(new Card(5, Card::SPADES));
    $this->assertEquals("Spelare 2 vinner!", $game21->processResult());

    $game21 -> newGame();
    $game21->getPlayer1Hand()->add(new Card(5, Card::HEARTS));
    $game21->getPlayer2Hand()->add(new Card(5, Card::SPADES));
    $this->assertEquals("Det är oavgjort!", $game21->processResult());

}
}