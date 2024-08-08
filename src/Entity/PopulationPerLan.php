<?php

namespace App\Entity;

use App\Repository\PopulationPerLanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PopulationPerLanRepository::class)]
class PopulationPerLan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private ?int $year = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $stockholm = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $uppsala = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $sodermanland = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $ostergotland = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $jonkoping = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $kronoberg = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $kalmar = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $gotland = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $blekinge = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $skane = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $halland = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $vastraGotaland = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $varmland = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $orebro = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $vastmanland = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $dalarnasLan = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $gavleborg = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $vasternorrland = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $jamtland = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $vasterbotten = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $norrbotten = null;

    // Getters and setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getStockholm(): ?int
    {
        return $this->stockholm;
    }

    public function setStockholm(?int $stockholm): static
    {
        $this->stockholm = $stockholm;

        return $this;
    }

    public function getUppsala(): ?int
    {
        return $this->uppsala;
    }

    public function setUppsala(?int $uppsala): static
    {
        $this->uppsala = $uppsala;

        return $this;
    }

    public function getSodermanland(): ?int
    {
        return $this->sodermanland;
    }

    public function setSodermanland(?int $sodermanland): static
    {
        $this->sodermanland = $sodermanland;

        return $this;
    }

    public function getOstergotland(): ?int
    {
        return $this->ostergotland;
    }

    public function setOstergotland(?int $ostergotland): static
    {
        $this->ostergotland = $ostergotland;

        return $this;
    }

    public function getJonkoping(): ?int
    {
        return $this->jonkoping;
    }

    public function setJonkoping(?int $jonkoping): static
    {
        $this->jonkoping = $jonkoping;

        return $this;
    }

    public function getKronoberg(): ?int
    {
        return $this->kronoberg;
    }

    public function setKronoberg(?int $kronoberg): static
    {
        $this->kronoberg = $kronoberg;

        return $this;
    }

    public function getKalmar(): ?int
    {
        return $this->kalmar;
    }

    public function setKalmar(?int $kalmar): static
    {
        $this->kalmar = $kalmar;

        return $this;
    }

    public function getGotland(): ?int
    {
        return $this->gotland;
    }

    public function setGotland(?int $gotland): static
    {
        $this->gotland = $gotland;

        return $this;
    }

    public function getBlekinge(): ?int
    {
        return $this->blekinge;
    }

    public function setBlekinge(?int $blekinge): static
    {
        $this->blekinge = $blekinge;

        return $this;
    }

    public function getSkane(): ?int
    {
        return $this->skane;
    }

    public function setSkane(?int $skane): static
    {
        $this->skane = $skane;

        return $this;
    }

    public function getHalland(): ?int
    {
        return $this->halland;
    }

    public function setHalland(?int $halland): static
    {
        $this->halland = $halland;

        return $this;
    }

    public function getVastraGotaland(): ?int
    {
        return $this->vastraGotaland;
    }

    public function setVastraGotaland(?int $vastraGotaland): static
    {
        $this->vastraGotaland = $vastraGotaland;

        return $this;
    }

    public function getVarmland(): ?int
    {
        return $this->varmland;
    }

    public function setVarmland(?int $varmland): static
    {
        $this->varmland = $varmland;

        return $this;
    }

    public function getOrebro(): ?int
    {
        return $this->orebro;
    }

    public function setOrebro(?int $orebro): static
    {
        $this->orebro = $orebro;

        return $this;
    }

    public function getVastmanland(): ?int
    {
        return $this->vastmanland;
    }

    public function setVastmanland(?int $vastmanland): static
    {
        $this->vastmanland = $vastmanland;

        return $this;
    }

    public function getDalarnasLan(): ?int
    {
        return $this->dalarnasLan;
    }

    public function setDalarnasLan(?int $dalarnasLan): static
    {
        $this->dalarnasLan = $dalarnasLan;

        return $this;
    }

    public function getGavleborg(): ?int
    {
        return $this->gavleborg;
    }

    public function setGavleborg(?int $gavleborg): static
    {
        $this->gavleborg = $gavleborg;

        return $this;
    }

    public function getVasternorrland(): ?int
    {
        return $this->vasternorrland;
    }

    public function setVasternorrland(?int $vasternorrland): static
    {
        $this->vasternorrland = $vasternorrland;

        return $this;
    }

    public function getJamtland(): ?int
    {
        return $this->jamtland;
    }

    public function setJamtland(?int $jamtland): static
    {
        $this->jamtland = $jamtland;

        return $this;
    }

    public function getVasterbotten(): ?int
    {
        return $this->vasterbotten;
    }

    public function setVasterbotten(?int $vasterbotten): static
    {
        $this->vasterbotten = $vasterbotten;

        return $this;
    }

    public function getNorrbotten(): ?int
    {
        return $this->norrbotten;
    }

    public function setNorrbotten(?int $norrbotten): static
    {
        $this->norrbotten = $norrbotten;

        return $this;
    }
}
