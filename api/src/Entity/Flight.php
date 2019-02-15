<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TimestampableTrait;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AcmeAssert;


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
 *     normalizationContext={"groups"={"flight_read"}},
 *     denormalizationContext={"groups"={"flight_write"}}
 * )
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
     * @Groups({"flight_read","flight_write"})
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
     * @Groups({"flight_read", "flight_write"})
     */
    private $departureDate;

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
     * @Groups({"flight_read", "flight_write"})
     */
    private $arrivalDate;

    /**
     * @var Plane the Flight Plane
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Plane", inversedBy="flights")
     * @Groups({"flight_read", "flight_write"})
     */
    private $plane;

    /**
     * @var Gate the Flight Gate
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Gate", inversedBy="flights")
     * @Groups({"flight_read", "flight_write"})
     */
    private $gate;

    /**
     * @var Airport the Flight Airport Departure
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flights_departure")
     * @Groups({"flight_read", "flight_write"})
     */
    private $airportDeparture;

    /**
     * @var Airport the Flight Airport Arrival
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flights_destination")
     * @Assert\Expression(
     *     "this.getAirportDeparture() !== this.getAirportDestination()",
     *     message="You must choose a different airport"
     * )
     * @Groups({"flight_read", "flight_write"})
     */
    private $airportDestination;

    /**
     * @var Journey the Journey the Flight is in
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Journey", mappedBy="flights")
     * @Groups({"flight_read", "flight_write"})
     */
    private $journeys;

    /**
     * @var User the Flight Passengers
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="flights")
     * @Groups({"flight_read", "flight_write"})
     */
    private $passengers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Luggage", inversedBy="flights")
     * @Groups({"flight_read"})
     */
    private $luggages;

    public function __construct()
    {
        $this->journeys = new ArrayCollection();
        $this->passengers = new ArrayCollection();
        $this->luggages = new ArrayCollection();
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
        return $this->airportDeparture;
    }

    public function setAirportDeparture(?Airport $airportDeparture): self
    {
        $this->airportDeparture = $airportDeparture;

        return $this;
    }

    public function getAirportDestination(): ?Airport
    {
        return $this->airportDestination;
    }

    public function setAirportDestination(?Airport $airportDestination): self
    {
        $this->airportDestination = $airportDestination;

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
        return $this->departureDate;
    }

    public function setDepartureDate(\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTimeInterface $arrivalDate): self
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    /**
     * @return Collection|Luggage[]
     */
    public function getLuggages(): Collection
    {
        return $this->luggages;
    }

    public function addLuggage(Luggage $luggage): self
    {
        if (!$this->luggages->contains($luggage)) {
            $this->luggages[] = $luggage;
        }

        return $this;
    }

    public function removeLuggage(Luggage $luggage): self
    {
        if ($this->luggages->contains($luggage)) {
            $this->luggages->removeElement($luggage);
        }

        return $this;
    }

}
