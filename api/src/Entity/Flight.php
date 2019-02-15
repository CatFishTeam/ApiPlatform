<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AcmeAssert;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\FlightRepository")
 */
class Flight
{
    use TimestampableTrait;

    /**
     * @var int the Flight Id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string the Flight reference
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("alnum")
     */
    private $reference;

    /**
     * @var \DateTime the Flight Departure Date
     *
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     * @Assert\GreaterThanOrEqual(
     *     "NOW",
     *     message="You can't take a trip which start before tooday"
     * )
     * @AcmeAssert\IsFlightInJourney()
     */
    private $departure_date;

    /**
     * @var \DateTime the Flight Arrival Date
     *
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     * @Assert\Expression(
     *     "this.getDepartureDate() <= this.getArrivalDate()",
     *     message="Arrivale date cannot be before departure date !"
     * )
     * @AcmeAssert\IsFlightInJourney()
     */
    private $arrival_date;

    /**
     * @var Plane the Flight Plane
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Plane", inversedBy="flights")
     */
    private $plane;

    /**
     * @var Gate the Flight Gate
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Gate", inversedBy="flights")
     */
    private $gate;

    /**
     * @var Airport the Flight Airport Departure
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flights_departure")
     */
    private $airport_departure;

    /**
     * @var Airport the Flight Airport Arrival
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flights_destination")
     */
    private $airport_destination;

    /**
     * @var Journey the Journey the Flight is in
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Journey", mappedBy="flights")
     */
    private $journeys;

    /**
     * @var User the Flight Passengers
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="flights")
     */
    private $passengers;

    public function __construct()
    {
        $this->journeys = new ArrayCollection();
        $this->passengers = new ArrayCollection();
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

    public function getPlane(): ?Plane
    {
        return $this->plane;
    }

    public function setPlane(?Plane $plane): self
    {
        $this->plane = $plane;

        return $this;
    }

    public function getGate(): ?Gate
    {
        return $this->gate;
    }

    public function setGate(?Gate $gate): self
    {
        $this->gate = $gate;

        return $this;
    }

    public function getAirportDeparture(): ?Airport
    {
        return $this->airport_departure;
    }

    public function setAirportDeparture(?Airport $airport_departure): self
    {
        $this->airport_departure = $airport_departure;

        return $this;
    }

    public function getAirportDestination(): ?Airport
    {
        return $this->airport_destination;
    }

    public function setAirportDestination(?Airport $airport_destination): self
    {
        $this->airport_destination = $airport_destination;

        return $this;
    }

    /**
     * @return Collection|Journey[]
     */
    public function getJourneys(): Collection
    {
        return $this->journeys;
    }

    public function addJourney(Journey $journey): self
    {
        if (!$this->journeys->contains($journey)) {
            $this->journeys[] = $journey;
            $journey->addFlight($this);
        }

        return $this;
    }

    public function removeJourney(Journey $journey): self
    {
        if ($this->journeys->contains($journey)) {
            $this->journeys->removeElement($journey);
            $journey->removeFlight($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getPassengers(): Collection
    {
        return $this->passengers;
    }

    public function addPassenger(User $passenger): self
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers[] = $passenger;
        }

        return $this;
    }

    public function removePassenger(User $passenger): self
    {
        if ($this->passengers->contains($passenger)) {
            $this->passengers->removeElement($passenger);
        }

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departure_date;
    }

    public function setDepartureDate(\DateTimeInterface $departure_date): self
    {
        $this->departure_date = $departure_date;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrival_date;
    }

    public function setArrivalDate(\DateTimeInterface $arrival_date): self
    {
        $this->arrival_date = $arrival_date;

        return $this;
    }

}
