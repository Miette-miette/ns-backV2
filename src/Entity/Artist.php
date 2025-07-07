<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Attribute\MaxDepth;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
#[Vich\Uploadable]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['api_event'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $biography = null;

    #[Groups(['api_event'])]
    #[Vich\UploadableField(mapping: 'ns_artist', fileNameProperty: 'imageName' )]
    private ?File $imageFile = null;

    #[Groups(['api_event'])]
    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[Groups(['api_event'])]
    #[SerializedName('imgUrl')]
    public function getImgUrl(): ?string
    {
        if (!$this->img) {
            return null;
        }

        return '/images/artist/' . $this->img;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): static
    {
        $this->biography = $biography;

        return $this;
    }

     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $img): void
    {
        $this->img = $img;
    }

    public function getImageName(): ?string
    {
        return $this->img;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
