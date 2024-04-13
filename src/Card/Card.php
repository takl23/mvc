<?php

namespace App\Card;

//use function PHPUnit\Framework\stringContains;
use InvalidArgumentException;

class Card
{
    
    private int $value; //siffra
    private int $suit; // 1=hjärter, 2=ruter, 3=klöver, 4=spader
    private string $color; // Färg


    // Constant for value
    public const ACE = 1;
    public const JACK = 11;
    public const QUEEN = 12;
    public const KING = 13;

    // Constant for suit
    public const HEARTS = 1;
    public const DIAMONDS = 2;
    public const CLUBS = 3;
    public const SPADES = 4;


   // Use constructor to always have a value and suite for card. 
   // If limit is outreached errormessage is thrown
    public function __construct(int $value, int $suit)
    {
        if ($value < 1 || $value > 13) {
            throw new InvalidArgumentException("Value must be between 1 and 13.");
        }

        if ($suit < 1 || $suit > 4) {
            throw new InvalidArgumentException("Invalid suit.");
        }

        $this->value = $value;
        $this->suit = $suit;
        $this->color = ($suit === self::HEARTS || $suit === self::DIAMONDS) ? 'red' : 'black';
    }

    public function getValue(): int
    {
        return $this->value;
    }

    
    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    // Create card
    public function representCard(): string
    {
        $values = [
            self::ACE => "A",
            2 => "2",
            3 => "3",
            4 => "4",
            5 => "5",
            6 => "6",
            7 => "7",
            8 => "8",
            9 => "9",
            10 => "10",
            self::JACK => "J",
            self::QUEEN => "Q",
            self::KING =>  "K",
        ];

        $suits = [
            self::HEARTS => "♥",
            self::DIAMONDS => "♦",
            self::CLUBS => "♣",
            self::SPADES => "♠",
        ];

        return $values[$this->getValue()] . " " . $suits[$this->getSuit()];

    }

}