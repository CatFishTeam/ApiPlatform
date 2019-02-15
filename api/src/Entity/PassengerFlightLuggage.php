<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PassengerFlightLuggageRepository")
 */
class PassengerFlightLuggage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="passengerFlightLuggage")
     */
    private $passenger;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Flight", inversedBy="passengerFlightLuggage")
     */
    private $flight;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Luggage", inversedBy="passengerFlightLuggage")
     */
    private $luggage;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(?Flight $flight): self
    {
        $this->flight = $flight;

        return $this;
    }

    public function getLuggage(): ?Luggage
    {
        return $this->luggage;
    }

    public function setLuggage(?Luggage $luggage): self
    {
        $this->luggage = $luggage;

        return $this;
    }
}
