<?php

namespace App\Entity;

use App\Repository\BanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BanRepository::class)]
class Ban
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    private ?string $ip = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $banned_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function getBannedAt(): ?\DateTimeImmutable
    {
        return $this->banned_at;
    }

    public function setBannedAt(\DateTimeImmutable $banned_at): static
    {
        $this->banned_at = $banned_at;

        return $this;
    }
}
