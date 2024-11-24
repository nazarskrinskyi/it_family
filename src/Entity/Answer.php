<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\DialogTrait;
use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class), ORM\Table(name: 'answers')]
class Answer
{
    use DialogTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $reactions = null;

    #[ORM\ManyToOne(targetEntity: Dialog::class, inversedBy: 'answers')]
    #[ORM\JoinColumn(nullable: false)]
    private Dialog $dialog;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $emoji = null;

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getReactions(): ?string
    {
        return $this->reactions;
    }

    public function setReactions(?string $reactions): void
    {
        $this->reactions = $reactions;
    }

    public function getDialog(): Dialog
    {
        return $this->dialog;
    }

    public function setDialog(Dialog $dialog): void
    {
        $this->dialog = $dialog;
    }

    public function getEmoji(): ?string
    {
        return $this->emoji;
    }

    public function setEmoji(?string $emoji): void
    {
        $this->emoji = $emoji;
    }

    public function __toString(): string
    {
        return $this->content . ' - ' . $this->emoji;
    }
}
