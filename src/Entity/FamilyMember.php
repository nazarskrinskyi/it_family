<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\FamilyTrait;
use App\Repository\FamilyMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilyMemberRepository::class), ORM\Table(name: 'family_members')]
class FamilyMember
{
    use FamilyTrait;

    #[ORM\ManyToOne(targetEntity: MainCharacter::class, inversedBy: 'familyMembers')]
    #[ORM\JoinColumn(nullable: false)]
    private MainCharacter $mainCharacter;

    public function getMainCharacter(): MainCharacter
    {
        return $this->mainCharacter;
    }

    public function setMainCharacter(MainCharacter $mainCharacter): void
    {
        $this->mainCharacter = $mainCharacter;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}