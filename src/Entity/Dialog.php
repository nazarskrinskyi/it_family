<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\DialogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DialogRepository::class), ORM\Table(name: 'dialogs')]
class Dialog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $answer = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(onDelete: "SET NULL")]
    private ?Dialog $parentDialog = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $selectedAnswer = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $emoji = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $reactions = null;

    #[ORM\ManyToMany(targetEntity: FamilyMember::class)]
    #[ORM\JoinTable(name: 'dialog_members')]
    private Collection $members;

    #[ORM\OneToMany(targetEntity: Answer::class, mappedBy: 'dialog', cascade: ['persist', 'remove'])]
    private Collection $answers;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getReactions(): ?string
    {
        return $this->reactions;
    }

    public function setReactions(?string $reactions): void
    {
        $this->reactions = $reactions;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): void
    {
        $this->answer = $answer;
    }

    public function getSelectedAnswer(): ?int
    {
        return $this->selectedAnswer;
    }

    public function setSelectedAnswer(?int $selectedAnswer): void
    {
        $this->selectedAnswer = $selectedAnswer;
    }

    public function getEmoji(): ?string
    {
        return $this->emoji;
    }

    public function setEmoji(?string $emoji): self
    {
        $this->emoji = $emoji;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getParentDialog(): ?Dialog
    {
        return $this->parentDialog;
    }

    public function setParentDialog(?Dialog $parentDialog): void
    {
        $this->parentDialog = $parentDialog;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function setMembers(Collection $members): void
    {
        $this->members = $members;
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function setAnswers(Collection $answers): void
    {
        $this->answers = $answers;
    }

    public function setPositive(bool $isPositive): static
    {
        $this->isPositive = $isPositive;

        return $this;
    }

    public function addMember(FamilyMember $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }

    public function removeMember(FamilyMember $member): static
    {
        $this->members->removeElement($member);

        return $this;
    }

    public function addAnswer(Answer $answer): static
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setDialog($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): static
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getDialog() === $this) {
                $answer->setDialog(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
