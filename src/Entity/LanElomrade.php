<?php

namespace App\Entity;

use App\Repository\LanElomradeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanElomradeRepository::class)]
class LanElomrade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lan = null;

    #[ORM\Column(length: 3)]
    private ?string $elomrade = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLan(): ?string
    {
        return $this->lan;
    }

    public function setLan(string $lan): static
    {
        $this->lan = $lan;

        return $this;
    }

    public function getElomrade(): ?string
    {
        return $this->elomrade;
    }

    public function setElomrade(string $elomrade): static
    {
        $this->elomrade = $elomrade;

        return $this;
    }
}
