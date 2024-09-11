<?php

namespace App\Tests\Entity;

use App\Entity\PopulationPerLan;
use PHPUnit\Framework\TestCase;

class PopulationPerLanTest extends TestCase
{
    public function testGetAndSetYear(): void
    {
        $entity = new PopulationPerLan();
        $entity->setYear(2023);
        $this->assertEquals(2023, $entity->getYear());
    }

    public function testGetAndSetStockholm(): void
    {
        $entity = new PopulationPerLan();
        $entity->setStockholm(1000000);
        $this->assertEquals(1000000, $entity->getStockholm());
    }

    public function testGetAndSetUppsala(): void
    {
        $entity = new PopulationPerLan();
        $entity->setUppsala(350000);
        $this->assertEquals(350000, $entity->getUppsala());
    }

    public function testGetAndSetSodermanland(): void
    {
        $entity = new PopulationPerLan();
        $entity->setSodermanland(290000);
        $this->assertEquals(290000, $entity->getSodermanland());
    }

    public function testGetAndSetOstergotland(): void
    {
        $entity = new PopulationPerLan();
        $entity->setOstergotland(460000);
        $this->assertEquals(460000, $entity->getOstergotland());
    }

    public function testGetAndSetJonkoping(): void
    {
        $entity = new PopulationPerLan();
        $entity->setJonkoping(370000);
        $this->assertEquals(370000, $entity->getJonkoping());
    }

    public function testGetAndSetKronoberg(): void
    {
        $entity = new PopulationPerLan();
        $entity->setKronoberg(200000);
        $this->assertEquals(200000, $entity->getKronoberg());
    }

    public function testGetAndSetKalmar(): void
    {
        $entity = new PopulationPerLan();
        $entity->setKalmar(250000);
        $this->assertEquals(250000, $entity->getKalmar());
    }

    public function testGetAndSetGotland(): void
    {
        $entity = new PopulationPerLan();
        $entity->setGotland(60000);
        $this->assertEquals(60000, $entity->getGotland());
    }

    public function testGetAndSetBlekinge(): void
    {
        $entity = new PopulationPerLan();
        $entity->setBlekinge(150000);
        $this->assertEquals(150000, $entity->getBlekinge());
    }

    public function testGetAndSetSkane(): void
    {
        $entity = new PopulationPerLan();
        $entity->setSkane(1300000);
        $this->assertEquals(1300000, $entity->getSkane());
    }

    public function testGetAndSetHalland(): void
    {
        $entity = new PopulationPerLan();
        $entity->setHalland(300000);
        $this->assertEquals(300000, $entity->getHalland());
    }

    public function testGetAndSetVastraGotaland(): void
    {
        $entity = new PopulationPerLan();
        $entity->setVastraGotaland(1600000);
        $this->assertEquals(1600000, $entity->getVastraGotaland());
    }

    public function testGetAndSetVarmland(): void
    {
        $entity = new PopulationPerLan();
        $entity->setVarmland(270000);
        $this->assertEquals(270000, $entity->getVarmland());
    }

    public function testGetAndSetOrebro(): void
    {
        $entity = new PopulationPerLan();
        $entity->setOrebro(300000);
        $this->assertEquals(300000, $entity->getOrebro());
    }

    public function testGetAndSetVastmanland(): void
    {
        $entity = new PopulationPerLan();
        $entity->setVastmanland(280000);
        $this->assertEquals(280000, $entity->getVastmanland());
    }

    public function testGetAndSetDalarnasLan(): void
    {
        $entity = new PopulationPerLan();
        $entity->setDalarnasLan(280000);
        $this->assertEquals(280000, $entity->getDalarnasLan());
    }

    public function testGetAndSetGavleborg(): void
    {
        $entity = new PopulationPerLan();
        $entity->setGavleborg(290000);
        $this->assertEquals(290000, $entity->getGavleborg());
    }

    public function testGetAndSetVasternorrland(): void
    {
        $entity = new PopulationPerLan();
        $entity->setVasternorrland(250000);
        $this->assertEquals(250000, $entity->getVasternorrland());
    }

    public function testGetAndSetJamtland(): void
    {
        $entity = new PopulationPerLan();
        $entity->setJamtland(130000);
        $this->assertEquals(130000, $entity->getJamtland());
    }

    public function testGetAndSetVasterbotten(): void
    {
        $entity = new PopulationPerLan();
        $entity->setVasterbotten(270000);
        $this->assertEquals(270000, $entity->getVasterbotten());
    }

    public function testGetAndSetNorrbotten(): void
    {
        $entity = new PopulationPerLan();
        $entity->setNorrbotten(250000);
        $this->assertEquals(250000, $entity->getNorrbotten());
    }
}
