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
 *     normalizationContext={"groups"={"airport_read"}},
 *     denormalizationContext={"groups"={"airport_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AirportRepository")
 */
class Airport
{
    /**
     * @var int The airport Id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string The airport Name
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Groups({"airport_read","airport_write"})
     */
    private $name;

    /**
     * @var Flight the flight departure from this airport
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="airportDeparture")
     * @Groups({"airport_read"})
     * @ApiSubresource(maxDepth=1)
     */
    private $flights_departure;

    /**
     * @var Flight the flight departure to this airport
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="airportDestination")
     * @Groups({"airport_read"})
     * @ApiSubresource(maxDepth=1)
     */
    private $flights_destination;

    /**
     * @var Location the airport Location
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Location", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"airport_read", "airport_write"})
     * @ApiSubresource(maxDepth=1)
     */
    private $location;

    public function __construct()
    {
        $this->flights_departure = new ArrayCollection();
        $this->flights_destination = new ArrayCollection();
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

    /**
     * @return Collection|Flight[]
     */
    public function getFlightsDeparture(): Collection
    {
        return $this->flights_departure;
    }

    public function addFlightsDeparture(Flight $flightsDeparture): self
    {
        if (!$this->flights_departure->contains($flightsDeparture)) {
            $this->flights_departure[] = $flightsDeparture;
            $flightsDeparture->setAirportDeparture($this);
        }

        return $this;
    }

    public function removeFlightsDeparture(Flight $flightsDeparture): self
    {
        if ($this->flights_departure->contains($flightsDeparture)) {
            $this->flights_departure->removeElement($flightsDeparture);
            // set the owning side to null (unless already changed)
            if ($flightsDeparture->getAirportDeparture() === $this) {
                $flightsDeparture->setAirportDeparture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlightsDestination(): Collection
    {
        return $this->flights_destination;
    }

    public function addFlightsDestination(Flight $flightsDestination): self
    {
        if (!$this->flights_destination->contains($flightsDestination)) {
            $this->flights_destination[] = $flightsDestination;
            $flightsDestination->setAirportDestination($this);
        }

        return $this;
    }

    public function removeFlightsDestination(Flight $flightsDestination): self
    {
        if ($this->flights_destination->contains($flightsDestination)) {
            $this->flights_destination->removeElement($flightsDestination);
            // set the owning side to null (unless already changed)
            if ($flightsDestination->getAirportDestination() === $this) {
                $flightsDestination->setAirportDestination(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): self
    {
        $this->location = $location;

        return $this;
    }
}
