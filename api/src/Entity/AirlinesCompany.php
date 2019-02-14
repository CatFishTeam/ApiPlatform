<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AirlinesCompanyRepository")
 */
class AirlinesCompany
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Assert\Expression(
     *     "this.getType() in ['Schedulded', 'Charter', 'Cargo', 'Governement', 'Passenger', 'Regional', 'Commuter', 'State-run', 'Air ambulances']",
     *     message="This is not a type acceptable"
     * )
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plane", mappedBy="airlines_company")
     */
    private $planes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="airlinesCompanies")
     * @ORM\JoinColumn(nullable=true)
     */
    private $headquarter_location;


    public function __construct()
    {
        $this->planes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $plane->setAirlinesCompany($this);
        }

        return $this;
    }

    public function removePlane(Plane $plane): self
    {
        if ($this->planes->contains($plane)) {
            $this->planes->removeElement($plane);
            // set the owning side to null (unless already changed)
            if ($plane->getAirlinesCompany() === $this) {
                $plane->setAirlinesCompany(null);
            }
        }

        return $this;
    }

    public function getHeadquarterLocation(): ?Location
    {
        return $this->headquarter_location;
    }

    public function setHeadquarterLocation(?Location $headquarter_location): self
    {
        $this->headquarter_location = $headquarter_location;

        return $this;
    }

}
