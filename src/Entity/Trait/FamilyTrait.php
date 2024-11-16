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

    #[ORM\Column(type: 'string', length: 255, nullable: true, enumType: RoleInFamily::class)]
    private ?RoleInFamily $roleInFamily = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, enumType: RoleInItTeam::class)]
    private ?RoleInItTeam $roleInItTeam = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $image = null;


    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
}