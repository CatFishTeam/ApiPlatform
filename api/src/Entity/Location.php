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
 *     normalizationContext={"groups"={"location_read"}},
 *     denormalizationContext={"groups"={"location_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @var int the Location Id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string the Location Country
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Groups({"location_read", "location_write"})
     */
    private $country;

    /**
     * @var string the Location City
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Groups({"location_read", "location_write"})
     */
    private $city;

    /**
     * @var string the Location Address
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Groups({"location_read", "location_write"})
     */
    private $address;

    /**
     * @var string the Location ZIP Code
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("alnum")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Groups({"location_read", "location_write"})
     */
    private $zip_code;

    /**
     * @var User the Users in the Location
     *
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="address")
     * @ApiSubresource(maxDepth=1)
     * @Groups({"location_read"})
     */
    private $users;

    /**
     * @var AirlinesCompany the AirlinesCompanys in the Location
     *
     * @ORM\OneToMany(targetEntity="App\Entity\AirlinesCompany", mappedBy="headquarterLocation")
     * @ApiSubresource(maxDepth=1)
     * @Groups({"location_read"})
     */
    private $airlinesCompanies;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->airlinesCompanies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAddress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getAddress() === $this) {
                $user->setAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AirlinesCompany[]
     */
    public function getAirlinesCompanies(): Collection
    {
        return $this->airlinesCompanies;
    }

    public function addAirlinesCompany(AirlinesCompany $airlinesCompany): self
    {
        if (!$this->airlinesCompanies->contains($airlinesCompany)) {
            $this->airlinesCompanies[] = $airlinesCompany;
            $airlinesCompany->setHeadquarterLocation($this);
        }

        return $this;
    }

    public function removeAirlinesCompany(AirlinesCompany $airlinesCompany): self
    {
        if ($this->airlinesCompanies->contains($airlinesCompany)) {
            $this->airlinesCompanies->removeElement($airlinesCompany);
            // set the owning side to null (unless already changed)
            if ($airlinesCompany->getHeadquarterLocation() === $this) {
                $airlinesCompany->setHeadquarterLocation(null);
            }
        }

        return $this;
    }
}
