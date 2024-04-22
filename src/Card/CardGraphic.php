<?php

namespace App\Card;


use Exception;

class CardGraphic extends Card
{
    private string $graphicRepresentation;
    private string $suit;

    public function __construct(int $value, int $suit)
    {
        parent::__construct($value, $suit);

        // Initialisera egenskapen för grafisk representation
        $this->graphicRepresentation = $this->representCardUnicode();
    }

//  public function representCardUnicode(): string
// {
//      // Variabler för att lagra Unicode-tecknet för kortet
//      $unicodeChar = '';

//      $heartsValues = [
//         self::ACE => "\u{1F0B1}", // A
//         2 => "\u{1F0B2}", // 2
//         3 => "\u{1F0B3}", // 3
//         4 => "\u{1F0B4}", // 4
//         5 => "\u{1F0B5}", // 5
//         6 => "\u{1F0B6}", // 6
//         7 => "\u{1F0B7}", // 7
//         8 => "\u{1F0B8}", // 8
//         9 => "\u{1F0B9}", // 9
//         10 => "\u{1F0BA}", // 10
//         self::JACK => "\u{1F0BB}", // J
//         self::QUEEN => "\u{1F0BD}", // Q
//         self::KING => "\u{1F0BE}", // K
//     ];
    
//         $diamondsValues = [
//             self::ACE => "\u{1F0C1}", // A
//             2 => "\u{1F0C2}", // 2
//             3 => "\u{1F0C3}", // 3
//             4 => "\u{1F0C4}", // 4
//             5 => "\u{1F0C5}", // 5
//             6 => "\u{1F0C6}", // 6
//             7 => "\u{1F0C7}", // 7
//             8 => "\u{1F0C8}", // 8
//             9 => "\u{1F0C9}", // 9
//             10 => "\u{1F0CA}", // 10
//             self::JACK => "\u{1F0CB}", // J
//             self::QUEEN => "\u{1F0CD}", // Q
//             self::KING => "\u{1F0CE}", // K
//         ];
        
//         $clubsValues = [
//             self::ACE => "\u{1F0D1}", // A
//             2 => "\u{1F0D2}", // 2
//             3 => "\u{1F0D3}", // 3
//             4 => "\u{1F0D4}", // 4
//             5 => "\u{1F0D5}", // 5
//             6 => "\u{1F0D6}", // 6
//             7 => "\u{1F0D7}", // 7
//             8 => "\u{1F0D8}", // 8
//             9 => "\u{1F0D9}", // 9
//             10 => "\u{1F0DA}", // 10
//             self::JACK => "\u{1F0DB}", // J
//             self::QUEEN => "\u{1F0DD}", // Q
//             self::KING => "\u{1F0DE}", // K
//         ];
        
//         $spadesValues = [
//             self::ACE => "\u{1F0A1}", // A
//             2 => "\u{1F0A2}", // 2
//             3 => "\u{1F0A3}", // 3
//             4 => "\u{1F0A4}", // 4
//             5 => "\u{1F0A5}", // 5
//             6 => "\u{1F0A6}", // 6
//             7 => "\u{1F0A7}", // 7
//             8 => "\u{1F0A8}", // 8
//             9 => "\u{1F0A9}", // 9
//             10 => "\u{1F0AA}", // 10
//             self::JACK => "\u{1F0AB}", // J
//             self::QUEEN => "\u{1F0AD}", // Q
//             self::KING => "\u{1F0AE}", // K
//         ];

//      // Hämta sviten och kortvärde för det aktuella kortet
//      $suit = $this->getSuit();
//      $value = $this->getValue();

//      // Generera Unicode-tecknet baserat på sviten och kortvärdet
//      if ($suit === self::HEARTS) {
//          $values = $heartsValues;
//      } elseif ($suit === self::DIAMONDS) {
//          $values = $diamondsValues;
//      } elseif ($suit === self::CLUBS) {
//          $values = $clubsValues;
//      } elseif ($suit === self::SPADES) {
//          $values = $spadesValues;
//      }

//      // Bygg ihop Unicode-tecknet
//      if (isset($values[$value])) {
//          $unicodeChar = $values[$value];
//      } else {
//          // Om kortvärdet inte finns i $values-arrayen
//          $unicodeChar = ''; // Eller hantera på annat sätt om kortvärdet är ogiltigt
//      }

//      // Returnera Unicode-tecknet som representerar kortet
//      return $unicodeChar;
//  }

public function representCardUnicode(): string
{
    // Variabler för att lagra Unicode-tecknet för kortet
    $unicodeChar = '';

    // Hämta sviten och kortvärdet för det aktuella kortet
    $suit = $this->getSuit();
    $value = $this->getValue();

    // Generera Unicode-tecknet för kortet
    $unicodeChar = $this->generateUnicodeChar($suit, $value);

    // Utskrift för att kontrollera matchad svit och kortvärde
    echo "Matchad svit: $suit\n";
    echo "Matchat kortvärde: $value\n";
    echo "Uni: $unicodeChar\n";

    // Returnera Unicode-tecknet som representerar kortet
    return $unicodeChar;
}

private function generateUnicodeChar(int $suit, int $value): string
{
    // Array med kortvärden och deras associerade Unicode-tecken för varje svit
    $cardValues = [
        self::HEARTS => [
            self::ACE => "\u{1F0B1}", // A
            2 => "\u{1F0B2}", // 2
            3 => "\u{1F0B3}", // 3
            4 => "\u{1F0B4}", // 4
            5 => "\u{1F0B5}", // 5
            6 => "\u{1F0B6}", // 6
            7 => "\u{1F0B7}", // 7
            8 => "\u{1F0B8}", // 8
            9 => "\u{1F0B9}", // 9
            10 => "\u{1F0BA}", // 10
            self::JACK => "\u{1F0BB}", // J
            self::QUEEN => "\u{1F0BD}", // Q
            self::KING => "\u{1F0BE}", // K
        ],
        self::DIAMONDS => [
            self::ACE => "\u{1F0C1}", // A
            2 => "\u{1F0C2}", // 2
            3 => "\u{1F0C3}", // 3
            4 => "\u{1F0C4}", // 4
            5 => "\u{1F0C5}", // 5
            6 => "\u{1F0C6}", // 6
            7 => "\u{1F0C7}", // 7
            8 => "\u{1F0C8}", // 8
            9 => "\u{1F0C9}", // 9
            10 => "\u{1F0CA}", // 10
            self::JACK => "\u{1F0CB}", // J
            self::QUEEN => "\u{1F0CD}", // Q
            self::KING => "\u{1F0CE}", // K
        ],
        self::CLUBS => [
            self::ACE => "\u{1F0D1}", // A
            2 => "\u{1F0D2}", // 2
            3 => "\u{1F0D3}", // 3
            4 => "\u{1F0D4}", // 4
            5 => "\u{1F0D5}", // 5
            6 => "\u{1F0D6}", // 6
            7 => "\u{1F0D7}", // 7
            8 => "\u{1F0D8}", // 8
            9 => "\u{1F0D9}", // 9
            10 => "\u{1F0DA}", // 10
            self::JACK => "\u{1F0DB}", // J
            self::QUEEN => "\u{1F0DD}", // Q
            self::KING => "\u{1F0DE}", // K
        ],
        self::SPADES => [
            self::ACE => "\u{1F0A1}", // A
            2 => "\u{1F0A2}", // 2
            3 => "\u{1F0A3}", // 3
            4 => "\u{1F0A4}", // 4
            5 => "\u{1F0A5}", // 5
            6 => "\u{1F0A6}", // 6
            7 => "\u{1F0A7}", // 7
            8 => "\u{1F0A8}", // 8
            9 => "\u{1F0A9}", // 9
            10 => "\u{1F0AA}", // 10
            self::JACK => "\u{1F0AB}", // J
            self::QUEEN => "\u{1F0AD}", // Q
            self::KING => "\u{1F0AE}", // K
        ],
    ];

    // Hämta de aktuella kortvärdena för den aktuella sviten
    $values = $cardValues[$suit] ?? [];

    // Bygg ihop Unicode-tecknet
    $unicodeChar = $values[$value] ?? '';

    return $unicodeChar;
}

}
