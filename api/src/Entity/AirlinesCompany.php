<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
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
 *     normalizationContext={"groups"={"airlines_read"}},
 *     denormalizationContext={"groups"={"airlines_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AirlinesCompanyRepository")
 */
class AirlinesCompany
{
    /**
     * @var int The airlines company Id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string The airlines company Name
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Groups({"airlines_read","airlines_write"})
     */
    private $name;

    /**
     * @var string The airlines company Type
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Assert\Expression(
     *     "this.getType() in ['Schedulded', 'Charter', 'Cargo', 'Governement', 'Passenger', 'Regional', 'Commuter', 'State-run', 'Air ambulances']",
     *     message="This is not a type acceptable"
     * )
     * @Groups({"airlines_read","airlines_write"})
     */
    private $type;

    /**
     * @var Plane The Planes possessed by this airlines company
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Plane", mappedBy="airlines_company")
     * @Groups({"airlines_read"})
     */
    private $planes;

    /**
     * @var Location The Location of this airlines company headquarter
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="airlinesCompanies")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"airlines_read"})
     */
    private $headquarterLocation;


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
        return $this->headquarterLocation;
    }

    public function setHeadquarterLocation(?Location $headquarterLocation): self
    {
        $this->headquarterLocation = $headquarterLocation;

        return $this;
    }

}
