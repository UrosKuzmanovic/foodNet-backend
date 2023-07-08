<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $time;

    /**
     * @ORM\OneToMany(targetEntity=Ingredient::class, mappedBy="recipe")
     */
    private ArrayCollection $ingredients;

    /**
     * @ORM\OneToMany(targetEntity=Tag::class, mappedBy="recipe")
     */
    private ArrayCollection $tags;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $shortDescription;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $tips;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $serving;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="recipes")
     */
    private ?Author $author;

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
     * @return ArrayCollection
     */
    public function getIngredients(): ArrayCollection
    {
        return $this->ingredients;
    }

    /**
     * @param ArrayCollection $ingredients
     * @return Recipe
     */
    public function setIngredients(ArrayCollection $ingredients): Recipe
    {
        $this->ingredients = $ingredients;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags(): ArrayCollection
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     * @return Recipe
     */
    public function setTags(ArrayCollection $tags): Recipe
    {
        $this->tags = $tags;
        return $this;
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
}
