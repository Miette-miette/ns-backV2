<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Attribute\MaxDepth;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[Vich\Uploadable]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api_location'])]
    private ?int $id = null;

    #[Groups(['api_event','api_location'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['api_location'])]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Groups(['api_location'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 16)]
    private ?string $lat = null;

    #[Groups(['api_location'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 16)]
    private ?string $lng = null;

    #[Groups(['api_location'])]
    #[Vich\UploadableField(mapping: 'ns_icon', fileNameProperty: 'imageName' )]
    private ?File $imageFile = null;

    #[Groups(['api_location'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[Groups(['api_location'])]
    #[MaxDepth(1)]
    #[ORM\OneToOne(mappedBy: 'name', cascade: ['persist', 'remove'])]
    private ?InfoLocation $infoLocation = null;

    #[Groups(['api_location'])]
    #[SerializedName('imgUrl')]
    public function getImgUrl(): ?string
    {
        if (!$this->icon) {
            return null;
        }

        return '/images/icon/' . $this->icon;
    }

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'location')]
    private Collection $events;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->events = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
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

    public function setImageName(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getImageName(): ?string
    {
        return $this->icon;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getInfoLocation(): ?InfoLocation
    {
        return $this->infoLocation;
    }

    public function setInfoLocation(?InfoLocation $infoLocation): static
    {
        // unset the owning side of the relation if necessary
        if ($infoLocation === null && $this->infoLocation !== null) {
            $this->infoLocation->setName(null);
        }

        // set the owning side of the relation if necessary
        if ($infoLocation !== null && $infoLocation->getName() !== $this) {
            $infoLocation->setName($this);
        }

        $this->infoLocation = $infoLocation;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setLocation($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getLocation() === $this) {
                $event->setLocation(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
