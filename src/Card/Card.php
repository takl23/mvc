<?php

namespace App\Card;

use Exception;

/**
 * Represents a card with a value, suit, and color.
 */

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


    /**
     * Constructor.
     * Initializes the card with a value and a suit.
     *
     * @param int $value The value of the card.
     * @param int $suit The suit of the card.
     * @throws Exception If the value is not between 1 and 13, or if the suit is not between 1 and 4.
     */

    // Use constructor to always have a value and suite for card.
    // If limit is outreached errormessage is thrown
    public function __construct(int $value, int $suit)
    {
        if ($value < 1 || $value > 13) {
            throw new Exception("Value must be between 1 and 13.");
        }

        if ($suit < 1 || $suit > 4) {
            throw new Exception("Invalid suit.");
        }

        $this->value = $value;
        $this->suit = $suit;
        $this->color = ($suit === self::HEARTS || $suit === self::DIAMONDS) ? 'red' : 'black';
    }


    /**
     * Fetches the value of the card.
     *
     * @return int The value of the card.
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Gets the suit of the card.
     *
     * @return int The suit of the card.
     */
    public function getSuit(): int
    {
        return $this->suit;
    }

    /**
     * Gets the color of the card.
     *
     * @return string The color of the card.
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * Creates a card as a string (value suit)
     *
     * @return string The string (value suit) of the card.
     */
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
