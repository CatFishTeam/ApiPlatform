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
 *     normalizationContext={"groups"={"luggage_read"}},
 *     denormalizationContext={"groups"={"luggage_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\LuggageRepository")
 */
class Luggage
{
    /**
     * @var int the Luggage Id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int the Luggage Number
     *
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     * @Groups({"luggage_read", "luggage_write"})
     */
    private $number;

    /**
     * @var float the Luggage Weight
     *
     * @ORM\Column(type="float")
     * @Assert\Type("float")
     * @Groups({"luggage_read", "luggage_write"})
     */
    private $weight;

    /**
     * @var User the User's Luggage
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="luggage", cascade={"persist", "remove"})
     * @ApiSubresource(maxDepth=1)
     * @Groups({"luggage_read"})
     */
    private $passenger;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PassengerFlightLuggage", mappedBy="luggage")
     */
    private $passengerFlightLuggage;

    public function __construct()
    {
        $this->passengerFlightLuggage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getPassenger(): ?User
    {
        return $this->passenger;
    }

    public function setPassenger(?User $passenger): self
    {
        $this->passenger = $passenger;

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

    /**
     * @return Collection|PassengerFlightLuggage[]
     */
    public function getPassengerFlightLuggage(): Collection
    {
        return $this->passengerFlightLuggage;
    }

    public function addPassengerFlightLuggage(PassengerFlightLuggage $passengerFlightLuggage): self
    {
        if (!$this->passengerFlightLuggage->contains($passengerFlightLuggage)) {
            $this->passengerFlightLuggage[] = $passengerFlightLuggage;
            $passengerFlightLuggage->setLuggage($this);
        }

        return $this;
    }

    public function removePassengerFlightLuggage(PassengerFlightLuggage $passengerFlightLuggage): self
    {
        if ($this->passengerFlightLuggage->contains($passengerFlightLuggage)) {
            $this->passengerFlightLuggage->removeElement($passengerFlightLuggage);
            // set the owning side to null (unless already changed)
            if ($passengerFlightLuggage->getLuggage() === $this) {
                $passengerFlightLuggage->setLuggage(null);
            }
        }

        return $this;
    }
}
