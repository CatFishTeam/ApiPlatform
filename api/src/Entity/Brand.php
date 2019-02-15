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
 *     normalizationContext={"groups"={"brand_read"}},
 *     denormalizationContext={"groups"={"brand_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 */
class Brand
{
    /**
     * @var int the Brand Id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string the Brand Name
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Groups({"brand_read","brand_write"})
     */
    private $name;

    /**
     * @var \DateTime the Brand foundation Date
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     * @Assert\LessThan("NOW +1 day")
     * @Groups({"brand_read","brand_write"})
     */
    private $foundedAt;

    /**
     * @var Model the models owned by the Brand
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Model", mappedBy="brand", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     * @Groups({"brand_read"})
     */
    private $models;

    public function __construct()
    {
        $this->models = new ArrayCollection();
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

    public function getFoundedAt(): ?\DateTimeInterface
    {
        return $this->foundedAt;
    }

    public function setFoundedAt(?\DateTimeInterface $foundedAt): self
    {
        $this->foundedAt = $foundedAt;

        return $this;
    }

    /**
     * @return Collection|Model[]
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Model $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models[] = $model;
            $model->setBrand($this);
        }

        return $this;
    }

    public function removeModel(Model $model): self
    {
        if ($this->models->contains($model)) {
            $this->models->removeElement($model);
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

        return $this;
    }
}
