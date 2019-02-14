<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AirportRepository")
 */
class Airport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="airport_departure")
     */
    private $flights_departure;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="airport_destination")
     */
    private $flights_destination;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Location", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
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
