<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use App\Enum\RoleInFamily;
use App\Enum\RoleInItTeam;
use Doctrine\ORM\Mapping as ORM;

trait FamilyTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $age;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $hobbies = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true, enumType: RoleInFamily::class)]
    private ?RoleInFamily $roleInFamily = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, enumType: RoleInItTeam::class)]
    private ?RoleInItTeam $roleInItTeam = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: 'integer', nullable: true, options: ['default' => 100])]
    private int $health = 100;

    #[ORM\Column(type: 'integer', nullable: true, options: ['default' => 100])]
    private int $energy = 100;

    #[ORM\Column(type: 'integer', nullable: true, options: ['default' => 50])]
    private int $mood = 50;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['default' => 'normal'])]
    private string $state = 'normal';

    #[ORM\Column(type: 'integer', nullable: true, options: ['default' => 50])]
    private int $hunger = 50;

    #[ORM\Column(type: 'integer', nullable: true,options: ['default' => 50])]
    private int $stress = 50;

    public function getRoleInFamily(): ?RoleInFamily
    {
        return $this->roleInFamily;
    }

    public function setRoleInFamily(?RoleInFamily $roleInFamily): void
    {
        $this->roleInFamily = $roleInFamily;
    }

    public function getRoleInItTeam(): ?RoleInItTeam
    {
        return $this->roleInItTeam;
    }

    public function setRoleInItTeam(?RoleInItTeam $roleInItTeam): void
    {
        $this->roleInItTeam = $roleInItTeam;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): void
    {
        $this->bio = $bio;
    }

    public function getHobbies(): ?array
    {
        return $this->hobbies;
    }

    public function setHobbies(?array $hobbies): void
    {
        $this->hobbies = $hobbies;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getHealth(): ?int
    {
        return $this->health ?? 100;
    }

    public function setHealth(?int $health): void
    {
        $this->health = max(0, min(100, $health));
    }

    public function getEnergy(): int
    {
        return $this->energy ?? 100;
    }

    public function setEnergy(int $energy): void
    {
        $this->energy = max(0, min(100, $energy));
    }

    public function getMood(): int
    {
        return $this->mood ?? 50;
    }

    public function setMood(int $mood): void
    {
        $this->mood = max(0, min(100, $mood));
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getHunger(): int
    {
        return $this->hunger ?? 50;
    }

    public function setHunger(int $hunger): void
    {
        $this->hunger = max(0, min(100, $hunger));
    }

    public function getStress(): int
    {
        return $this->stress ?? 50;
    }

    public function setStress(int $stress): void
    {
        $this->stress = max(0, min(100, $stress));
    }

    // Utility methods for updating parameters
    public function increaseHealth(int $amount): void
    {
        $this->setHealth($this->health + $amount);
    }

    public function decreaseHealth(int $amount): void
    {
        $this->setHealth($this->health - $amount);
    }

    public function increaseEnergy(int $amount): void
    {
        $this->setEnergy($this->energy + $amount);
    }

    public function decreaseEnergy(int $amount): void
    {
        $this->setEnergy($this->energy - $amount);
    }

    public function increaseMood(int $amount): void
    {
        $this->setMood($this->mood + $amount);
    }

    public function decreaseMood(int $amount): void
    {
        $this->setMood($this->mood - $amount);
    }

    public function increaseHunger(int $amount): void
    {
        $this->setHunger($this->hunger + $amount);
    }

    public function decreaseHunger(int $amount): void
    {
        $this->setHunger($this->hunger - $amount);
    }

    public function increaseStress(int $amount): void
    {
        $this->setStress($this->stress + $amount);
    }

    public function decreaseStress(int $amount): void
    {
        $this->setStress($this->stress - $amount);
    }

    // Derived logic
    public function updateState(): self
    {
        if ($this->stress > 80) {
            $this->mood = max(0, $this->mood - 10);
        }

        if ($this->hunger > 70) {
            $this->decreaseEnergy(10);
        }

        if ($this->health < 30) {
            $this->state = 'sick';
        } elseif ($this->energy < 20) {
            $this->state = 'exhausted';
        } else {
            $this->state = 'normal';
        }

        return $this;
    }
}
