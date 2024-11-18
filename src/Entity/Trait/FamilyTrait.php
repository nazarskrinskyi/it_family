<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use App\Enum\RoleInFamily;
use App\Enum\RoleInItTeam;
use DateTimeInterface;
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

    #[ORM\Column(type: 'date', nullable: true)]
    private ?DateTimeInterface $birthDate = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $favoriteColor = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $hobbies = [];

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $personalityType = null;

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

    /**
     * @return DateTimeInterface|null
     */
    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * @param DateTimeInterface|null $birthDate
     */
    public function setBirthDate(?DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string|null
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * @param string|null $bio
     */
    public function setBio(?string $bio): void
    {
        $this->bio = $bio;
    }

    /**
     * @return string|null
     */
    public function getFavoriteColor(): ?string
    {
        return $this->favoriteColor ?? null;
    }

    /**
     * @param string|null $favoriteColor
     */
    public function setFavoriteColor(?string $favoriteColor): void
    {
        $this->favoriteColor = $favoriteColor;
    }

    /**
     * @return array
     */
    public function getHobbies(): ?array
    {
        return $this->hobbies;
    }

    /**
     * @return string|null
     */
    public function getPersonalityType(): ?string
    {
        return $this->personalityType;
    }

    /**
     * @param string|null $personalityType
     */
    public function setPersonalityType(?string $personalityType): void
    {
        $this->personalityType = $personalityType;
    }

    /**
     * @param ?array $hobbies
     */
    public function setHobbies(?array $hobbies): void
    {
        $this->hobbies = $hobbies;
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