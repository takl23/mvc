<?php

namespace App\Card;
class CardGraphic extends Card
{
    private string $graphicRepresentation;

    public static array $cardValues = [
        Card::HEARTS => [
            Card::ACE => "\u{1F0B1}",
            2 => "\u{1F0B2}",
            3 => "\u{1F0B3}",
            4 => "\u{1F0B4}",
            5 => "\u{1F0B5}",
            6 => "\u{1F0B6}",
            7 => "\u{1F0B7}",
            8 => "\u{1F0B8}",
            9 => "\u{1F0B9}",
            10 => "\u{1F0BA}",
            Card::JACK => "\u{1F0BB}",
            Card::QUEEN => "\u{1F0BD}",
            Card::KING => "\u{1F0BE}",
        ],
        Card::DIAMONDS => [
            Card::ACE => "\u{1F0C1}",
            2 => "\u{1F0C2}",
            3 => "\u{1F0C3}",
            4 => "\u{1F0C4}",
            5 => "\u{1F0C5}",
            6 => "\u{1F0C6}",
            7 => "\u{1F0C7}",
            8 => "\u{1F0C8}",
            9 => "\u{1F0C9}",
            10 => "\u{1F0CA}",
            Card::JACK => "\u{1F0DB}",
            Card::QUEEN => "\u{1F0DD}",
            Card::KING => "\u{1F0CE}",
        ],
        Card::CLUBS => [
            Card::ACE => "\u{1F0D1}",
            2 => "\u{1F0D2}",
            3 => "\u{1F0D3}",
            4 => "\u{1F0D4}",
            5 => "\u{1F0D5}",
            6 => "\u{1F0D6}",
            7 => "\u{1F0D7}",
            8 => "\u{1F0D8}",
            9 => "\u{1F0D9}",
            10 => "\u{1F0DA}",
            Card::JACK => "\u{1F0DB}",
            Card::QUEEN => "\u{1F0DD}",
            Card::KING => "\u{1F0DE}",
        ],
        Card::SPADES => [
            Card::ACE => "\u{1F0A1}", 
            2 => "\u{1F0A2}",
            3 => "\u{1F0A3}",
            4 => "\u{1F0A4}",
            5 => "\u{1F0A5}",
            6 => "\u{1F0A6}",
            7 => "\u{1F0A7}",
            8 => "\u{1F0A8}",
            9 => "\u{1F0A9}",
            10 => "\u{1F0AA}",
            self::JACK => "\u{1F0AB}",
            self::QUEEN => "\u{1F0AD}",
            self::KING => "\u{1F0AE}",
        ],
    ]; 

    public function __construct(int $value, int $suit)
    {
        parent::__construct($value, $suit);

        // Initialisera egenskapen för grafisk representation
        $this->graphicRepresentation = $this->representCardUnicode();
    }

    public function representCardUnicode(): string
    {
        // Hämta Unicode-teckenmappningen för färgen
        $values = self::$cardValues[$this->getSuit()] ?? [];

        // Hämta Unicode-tecknet baserat på värdet inom färgmappningen
        $unicodeChar = $values[$this->getValue()] ?? '';

        return $unicodeChar;
    }

    public function getGraphicRepresentation(): string
    {
        return $this->graphicRepresentation;
    }
    
    public function __toString(): string
{
    return $this->getGraphicRepresentation();
}

}
