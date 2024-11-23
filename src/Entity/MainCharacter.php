<?php

declare(strict_types=1);

namespace App\Entity;

namespace App\Entity;

use App\Entity\Trait\FamilyTrait;
use App\Repository\MainCharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MainCharacterRepository::class), ORM\Table(name: 'main_characters')]
class MainCharacter
{
    use FamilyTrait;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $isActive = true;

    #[ORM\OneToMany(targetEntity: FamilyMember::class, mappedBy: 'mainCharacter', cascade: ['persist', 'remove'])]
    private Collection $familyMembers;

    public function __construct()
    {
        $this->familyMembers = new ArrayCollection();
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getFamilyMembers(): Collection
    {
        return $this->familyMembers;
    }

    public function addFamilyMember(FamilyMember $familyMember): void
    {
        if (!$this->familyMembers->contains($familyMember)) {
            $familyMember->setMainCharacter($this);
            $this->familyMembers->add($familyMember);
        }
    }

    public function removeFamilyMember(FamilyMember $familyMember): void
    {
        if ($this->familyMembers->contains($familyMember)) {
            $this->familyMembers->removeElement($familyMember);
        }
    }

    public function setFamilyMembers(Collection $familyMembers): void
    {
        $this->familyMembers = $familyMembers;
    }

    public function validateAgeDifference(MainCharacter $mainCharacter): bool
    {
        $difference = abs($this->getAge() - $mainCharacter->getAge());
        return $difference >= 16;
    }
}
