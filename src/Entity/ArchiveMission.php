<?php

namespace App\Entity;

use App\Repository\ArchiveMissionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArchiveMissionRepository::class)]
class ArchiveMission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $budget = null;

    #[ORM\Column]
    private ?\DateTime $deadline = null;

    #[ORM\Column(length: 50)]
    private ?string $language = null;

    #[ORM\Column]
    private ?int $advance_rate = null;

    #[ORM\Column(nullable: true)]
    private ?int $advance_paid = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $archived_at = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?StatusMission $status_mission = null;

    #[ORM\ManyToOne(inversedBy: 'archiveMissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDeadline(): ?\DateTime
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTime $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getAdvanceRate(): ?int
    {
        return $this->advance_rate;
    }

    public function setAdvanceRate(int $advance_rate): static
    {
        $this->advance_rate = $advance_rate;

        return $this;
    }

    public function getAdvancePaid(): ?int
    {
        return $this->advance_paid;
    }

    public function setAdvancePaid(?int $advance_paid): static
    {
        $this->advance_paid = $advance_paid;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getArchivedAt(): ?\DateTimeImmutable
    {
        return $this->archived_at;
    }

    public function setArchivedAt(\DateTimeImmutable $archived_at): static
    {
        $this->archived_at = $archived_at;

        return $this;
    }

    public function getStatusMission(): ?StatusMission
    {
        return $this->status_mission;
    }

    public function setStatusMission(?StatusMission $status_mission): static
    {
        $this->status_mission = $status_mission;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user_id): static
    {
        $this->user = $user_id;

        return $this;
    }
}
