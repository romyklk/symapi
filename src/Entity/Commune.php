<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\DBAL\Types\Types;
use ORM\Transient; // pour ne pas persister cette classe

#[Transient] // pour ne pas persister cette classe
class Commune
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $codeDepartement = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $codeRegion = null;

    #[ORM\Column]
    private ?int $population = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $codesPostaux = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCodeDepartement(): ?string
    {
        return $this->codeDepartement;
    }

    public function setCodeDepartement(string $codeDepartement): static
    {
        $this->codeDepartement = $codeDepartement;

        return $this;
    }

    public function getCodeRegion(): ?string
    {
        return $this->codeRegion;
    }

    public function setCodeRegion(string $codeRegion): static
    {
        $this->codeRegion = $codeRegion;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(int $population): static
    {
        $this->population = $population;

        return $this;
    }

    public function getCodesPostaux(): array
    {
        return $this->codesPostaux;
    }

    public function setCodesPostaux(array $codesPostaux): static
    {
        $this->codesPostaux = $codesPostaux;

        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }
}
