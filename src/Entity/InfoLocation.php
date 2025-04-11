<?php

namespace App\Entity;

use App\Repository\InfoLocationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoLocationRepository::class)]
class InfoLocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $opening = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closing = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_location = null;

    #[ORM\OneToOne(inversedBy: 'infoLocation', cascade: ['persist', 'remove'])]
    private ?Location $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOpening(): ?\DateTimeInterface
    {
        return $this->opening;
    }

    public function setOpening(\DateTimeInterface $opening): static
    {
        $this->opening = $opening;

        return $this;
    }

    public function getClosing(): ?\DateTimeInterface
    {
        return $this->closing;
    }

    public function setClosing(\DateTimeInterface $closing): static
    {
        $this->closing = $closing;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImgLocation(): ?string
    {
        return $this->img_location;
    }

    public function setImgLocation(?string $img_location): static
    {
        $this->img_location = $img_location;

        return $this;
    }

    public function getName(): ?Location
    {
        return $this->name;
    }

    public function setName(?Location $name): static
    {
        $this->name = $name;

        return $this;
    }
}
