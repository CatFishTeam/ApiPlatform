<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 * collectionOperations={
 *          "get",
 *          "post"={"validation_groups"={"Default", "postValidation"}}
 *     },
 *     itemOperations={
 *          "delete",
 *          "get",
 *          "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *     normalizationContext={"groups"={"plane_read"}},
 *     denormalizationContext={"groups"={"plane_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PlaneRepository")
 */
class Plane
{
    /**
     * @var int the Plane Id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string the Plane Reference
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("alnum")
     * @Groups({"plane_read","plane_wirte","airlines_read"})
     */
    private $reference;

    /**
     * @var Model the Plane Model
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Model", inversedBy="planes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $model;

    /**
     * @var AirlinesCompany the Plane Airlines Company
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\AirlinesCompany", inversedBy="planes")
     */
    private $airlines_company;

    /**
     * @var AirlinesCompany the Plane Flights
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="plane")
     * @ApiSubresource(maxDepth=1)
     * @Groups({"read"})
     */
    private $flights;

    public function __construct()
    {
        $this->flights = new ArrayCollection();
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

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getAirlinesCompany(): ?AirlinesCompany
    {
        return $this->airlines_company;
    }

    public function setAirlinesCompany(?AirlinesCompany $airlines_company): self
    {
        $this->airlines_company = $airlines_company;

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flight $flight): self
    {
        if (!$this->flights->contains($flight)) {
            $this->flights[] = $flight;
            $flight->setPlane($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            // set the owning side to null (unless already changed)
            if ($flight->getPlane() === $this) {
                $flight->setPlane(null);
            }
        }

        return $this;
    }
}
