<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"list"})
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"list"})
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank()
     * @Groups({"list"})
     */
    private ?int $time = null;

    /**
     * @var Ingredient[]|Collection
     * @ORM\OneToMany(targetEntity=Ingredient::class, mappedBy="recipe", cascade={"all"})
     * @Groups({"recipe_serialization"})
     */
    private Collection $ingredients;

    /**
     * @var Tag[]|Collection
     * @ORM\OneToMany(targetEntity=Tag::class, mappedBy="recipe", cascade={"all"})
     * @Groups({"recipe_serialization"})
     */
    private Collection $tags;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     * @Groups({"list"})
     */
    private ?string $shortDescription = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     * @Groups({"list"})
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"list"})
     */
    private ?string $tips = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"list"})
     */
    private ?string $serving = null;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="recipes")
     * @Groups({"list"})
     */
    private ?Author $author = null;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"list"})
     */
    private bool $archived = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"list"})
     */
    private ?\DateTime $createdAt = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"list"})
     */
    private ?\DateTime $updatedAt = null;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, inversedBy="recipe", cascade={"persist", "remove"})
     * @Groups({"list"})
     */
    private ?Image $image = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $deletedAt = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Recipe
     */
    public function setId(int $id): Recipe
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Recipe
     */
    public function setName(?string $name): Recipe
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTime(): ?int
    {
        return $this->time;
    }

    /**
     * @param int|null $time
     * @return Recipe
     */
    public function setTime(?int $time): Recipe
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    /**
     * @param Collection $ingredients
     * @return Recipe
     */
    public function setIngredients(Collection $ingredients): Recipe
    {
        $this->ingredients = $ingredients;
        return $this;
    }

    /**
     * @param Ingredient $ingredient
     */
    public function addIngredient(Ingredient $ingredient)
    {
        $ingredient->setRecipe($this);
        $this->ingredients->add($ingredient);
    }

    /**
     * @param Ingredient $ingredient
     */
    public function removeIngredient(Ingredient $ingredient)
    {
        $ingredient->setRecipe(null);
        $this->ingredients->removeElement($ingredient);
    }


    /**
     * @return Collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @param Collection $tags
     * @return Recipe
     */
    public function setTags(Collection $tags): Recipe
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $tag->setRecipe($this);
        $this->tags->add($tag);
    }

    /**
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $tag->setRecipe(null);
        $this->tags->removeElement($tag);
    }

    /**
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @param string|null $shortDescription
     * @return Recipe
     */
    public function setShortDescription(?string $shortDescription): Recipe
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Recipe
     */
    public function setDescription(?string $description): Recipe
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTips(): ?string
    {
        return $this->tips;
    }

    /**
     * @param string|null $tips
     * @return Recipe
     */
    public function setTips(?string $tips): Recipe
    {
        $this->tips = $tips;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getServing(): ?string
    {
        return $this->serving;
    }

    /**
     * @param string|null $serving
     * @return Recipe
     */
    public function setServing(?string $serving): Recipe
    {
        $this->serving = $serving;
        return $this;
    }

    /**
     * @return Author|null
     */
    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    /**
     * @param Author|null $author
     * @return Recipe
     */
    public function setAuthor(?Author $author): Recipe
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->archived;
    }

    /**
     * @param bool $archived
     * @return Recipe
     */
    public function setArchived(bool $archived): Recipe
    {
        $this->archived = $archived;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     * @return Recipe
     */
    public function setCreatedAt(?\DateTime $createdAt): Recipe
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     * @return Recipe
     */
    public function setUpdatedAt(?\DateTime $updatedAt): Recipe
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Image|null
     */
    public function getImage(): ?Image
    {
        return $this->image;
    }

    /**
     * @param Image|null $image
     * @return Recipe
     */
    public function setImage(?Image $image): Recipe
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime|null $deletedAt
     * @return Recipe
     */
    public function setDeletedAt(?\DateTime $deletedAt): Recipe
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }
}
