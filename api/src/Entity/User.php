<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Traits\TimestampableTrait;

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
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user_account")
 */
class User implements UserInterface
{
    use TimestampableTrait;

    /**
     * @var int the User Id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string the User Lastname
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"write", "read"})
     * @Assert\Type("string")
     */
    private $lastname;

    /**
     * @var string the User Firstname
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"write", "read"})
     * @Assert\Type("string")
     */
    private $firstname;

    /**
     * @var string the User Email
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({"write", "read"})
     * @Assert\Email(checkMX=true)
     */
    private $email;

    /**
     * @var \DateTime the User Birth Date
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime
     * @Assert\LessThanOrEqual(
     *     "NOW",
     *     message="What kind of user is this ?"
     * )
     * @Groups({"write", "read"})
     */
    private $birthdate;

    /**
     * @var string the User Password
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Type("alnum")
     */
    private $password;

    /**
     * @var string the User clear password
     *
     * @Assert\Length(
     *     min="6",
     *     groups={"postValidation", "putValidaion"}
     * )
     * @Assert\NotEqualTo(
     *     propertyPath="password",
     *     groups={"putValidation"}
     * )
     * @Groups({"write"})
     */
    private $plainPassword;

    /**
     * @var string the User Phone
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("alnum")
     * @Groups({"write", "read"})
     * @Assert\Length(
     *      min = 10,
     *      max = 20,
     *      minMessage = "Your first phone number must be at least {{ limit }} characters long",
     *      maxMessage = "Your first phone number cannot be longer than {{ limit }} characters"
     * )
     */
    private $phone;

    /**
     * @var string the User Role(s)
     *
     * @ORM\Column(type="json_array", nullable=true)
     * @Groups({"write", "read"})
     * @Assert\Expression(
     *     "this.getRoles() != NULL ? this.getRoles() in ['ROLE_USER','ROLE_ADMIN','ROLE_PASSENGER'] : true",
     *     message="A user must be in one of thoose roles : ROLE_USER, ROLE_ADMIN, ROLE_PASSENGER"
     * )
     */
    private $roles;

    /**
     * @var Flight the User Flights
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Flight", mappedBy="passengers")
     */
    private $flights;

    /**
     * @var Location the User Address
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="users")
     */
    private $address;

    /**
     * @var Luggage the User Luggage
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Luggage", mappedBy="passenger", cascade={"persist", "remove"})
     * @ApiSubresource()
     */
    private $luggage;


    public function __construct()
    {
        $this->flights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getRoles()
    {
        $roles = $this->roles;

        return $roles;
    }

    public function setRoles($roles): self
    {

        $this->roles =  $roles;

        return $this;
    }


    /**
     * @return Collection|Flight[]
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flight $flight): self
    {
        if (!$this->flights->contains($flight)) {
            $this->flights[] = $flight;
            $flight->addPassenger($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            $flight->removePassenger($this);
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?Location
    {
        return $this->address;
    }

    public function setAddress(?Location $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLuggage(): ?Luggage
    {
        return $this->luggage;
    }

    public function setLuggage(?Luggage $luggage): self
    {
        $this->luggage = $luggage;

        // set (or unset) the owning side of the relation if necessary
        $newPassenger = $luggage === null ? null : $this;
        if ($newPassenger !== $luggage->getPassenger()) {
            $luggage->setPassenger($newPassenger);
        }

        return $this;
    }
}
