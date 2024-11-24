<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait DialogTrait
{
    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private ?string $health = null;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private ?string $energy = null;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private ?string $mood = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $state = null;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private ?string $hunger = null;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private ?string $stress = null;

    // Getters and Setters with Conversion
    public function getHealth(): ?string
    {
        return $this->health !== null ? (string)$this->health : null;
    }

    public function setHealth(?string $health): void
    {
        $this->health = $health !== null ? sprintf('%+d', max(-100, min(100, $health))) : null;
    }

    public function getEnergy(): ?string
    {
        return $this->energy !== null ? (string)$this->energy : null;
    }

    public function setEnergy(?string $energy): void
    {
        $this->energy = $energy !== null ? sprintf('%+d', max(-100, min(100, $energy))) : null;
    }

    public function getMood(): ?string
    {
        return $this->mood !== null ? (string)$this->mood : null;
    }

    public function setMood(?string $mood): void
    {
        $this->mood = $mood !== null ? sprintf('%+d', max(-100, min(100, $mood))) : null;
    }

    public function getHunger(): ?string
    {
        return $this->hunger !== null ? (string)$this->hunger : null;
    }

    public function setHunger(?string $hunger): void
    {
        $this->hunger = $hunger !== null ? sprintf('%+d', max(-100, min(100, $hunger))) : null;
    }

    public function getStress(): ?string
    {
        return $this->stress !== null ? (string)$this->stress : null;
    }

    public function setStress(?string $stress): void
    {
        $this->stress = $stress !== null ? sprintf('%+d', max(-100, min(100, $stress))) : null;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): void
    {
        $this->state = $state;
    }
}
