<?php

namespace App\Entity;

use App\Repository\MapRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MapRepository::class)]
class Map
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['api_location'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 16)]
    private ?string $lat = null;

    #[Groups(['api_location'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 16)]
    private ?string $lng = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(string $lng): static
    {
        $this->lng = $lng;

        return $this;
    }
}
