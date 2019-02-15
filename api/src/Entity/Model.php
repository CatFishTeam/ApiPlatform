<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ModelRepository")
 */
class Model
{
    /**
     * @var int the Model Id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string the Model Reference
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("alnum")
     */
    private $reference;

    /**
     * @var int the Model Number Of Seats
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("integer")
     */
    private $numberOfSeat;

    /**
     * @var float the Model Weight
     *
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("float")
     */
    private $weight;

    /**
     * @var float the Model Length
     *
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("float")
     */
    private $length;

    /**
     * @var float the Model Width
     *
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("float")
     */
    private $width;

    /**
     * @var Brand the Brand of the Model
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand", inversedBy="models")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @var Plane the Planes of the Model
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Plane", mappedBy="model", orphanRemoval=true)
     * @Groups({"read"})
     */
    private $planes;

    public function __construct()
    {
        $this->planes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getNumberOfSeat(): ?int
    {
        return $this->numberOfSeat;
    }

    public function setNumberOfSeat(int $numberOfSeat): self
    {
        $this->numberOfSeat = $numberOfSeat;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|Plane[]
     */
    public function getPlanes(): Collection
    {
        return $this->planes;
    }

    public function addPlane(Plane $plane): self
    {
        if (!$this->planes->contains($plane)) {
            $this->planes[] = $plane;
            $plane->setModel($this);
        }

        return $this;
    }

    public function removePlane(Plane $plane): self
    {
        if ($this->planes->contains($plane)) {
            $this->planes->removeElement($plane);
            // set the owning side to null (unless already changed)
            if ($plane->getModel() === $this) {
                $plane->setModel(null);
            }
        }

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setLength(float $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(float $width): self
    {
        $this->width = $width;

        return $this;
    }
}
