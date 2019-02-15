<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource()
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
     */
    private $number;

    /**
     * @var float the Luggage Weight
     *
     * @ORM\Column(type="float")
     * @Assert\Type("float")
     */
    private $weight;

    /**
     * @var User the User's Luggage
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="luggage", cascade={"persist", "remove"})
     * @ApiSubresource(maxDepth=1)
     */
    private $passenger;

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
}
