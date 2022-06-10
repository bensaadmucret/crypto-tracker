<?php

namespace App\Entity;

use App\Repository\TokenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
class Token
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 80)]
    private $name;

    #[ORM\Column(type: 'string', length: 85)]
    private $slug;

    #[ORM\Column(type: 'string', length: 80)]
    private $symbol;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'float')]
    private $change_24h;

    #[ORM\Column(type: 'float')]
    private $change_1h;

    #[ORM\Column(type: 'float')]
    private $change_7d;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getChange24h(): ?float
    {
        return $this->change_24h;
    }

    public function setChange24h(float $change_24h): self
    {
        $this->change_24h = $change_24h;

        return $this;
    }

    public function getChange1h(): ?float
    {
        return $this->change_1h;
    }

    public function setChange1h(float $change_1h): self
    {
        $this->change_1h = $change_1h;

        return $this;
    }

    public function getChange7d(): ?float
    {
        return $this->change_7d;
    }

    public function setChange7d(float $change_7d): self
    {
        $this->change_7d = $change_7d;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->change_24h = 0;
        $this->change_1h = 0;
        $this->change_7d = 0;
    }

    

}
