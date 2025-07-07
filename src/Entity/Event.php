<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[Groups(['api_event'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['api_event'])]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Groups(['api_event'])]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Artist $artist = null;

    #[Groups(['api_event'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[Groups(['api_event'])]
    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $begin_time = null;

    #[Groups(['api_event'])]
    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $end_time = null;

    #[Groups(['api_event'])]
    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?Location $location = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): static
    {
        $this->artist = $artist;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getBeginTime(): ?\DateTimeInterface
    {
        return $this->begin_time;
    }

    public function setBeginTime(\DateTimeInterface $begin_time): static
    {
        $this->begin_time = $begin_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): static
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function __toString()
    {
        return $this->artist;
    }
}
