<?php

namespace App\Tests\Entity;

use App\Entity\LanElomrade;
use PHPUnit\Framework\TestCase;

class LanElomradeTest extends TestCase
{
    public function testGetAndSetLan(): void
    {
        // Skapa ett nytt LanElomrade-objekt
        $lanElomrade = new LanElomrade();

        // Testa setLan och getLan
        $lanElomrade->setLan('Stockholm');
        $this->assertEquals('Stockholm', $lanElomrade->getLan());
    }

    public function testGetAndSetElomrade(): void
    {
        // Skapa ett nytt LanElomrade-objekt
        $lanElomrade = new LanElomrade();

        // Testa setElomrade och getElomrade
        $lanElomrade->setElomrade('SE1');
        $this->assertEquals('SE1', $lanElomrade->getElomrade());
    }

    public function testGetId(): void
    {
        // Skapa ett nytt LanElomrade-objekt
        $lanElomrade = new LanElomrade();

        // Eftersom ID normalt genereras av databasen ska det initialt vara null
        $this->assertNull($lanElomrade->getId());
    }
}
