<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Recipe::class, inversedBy="ingredients")
     */
    private Recipe $recipe;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Ingredient
     */
    public function setId(int $id): Ingredient
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
     * @return Ingredient
     */
    public function setName(?string $name): Ingredient
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    /**
     * @param string|null $quantity
     * @return Ingredient
     */
    public function setQuantity(?string $quantity): Ingredient
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return Recipe
     */
    public function getRecipe(): Recipe
    {
        return $this->recipe;
    }

    /**
     * @param Recipe $recipe
     * @return Ingredient
     */
    public function setRecipe(Recipe $recipe): Ingredient
    {
        $this->recipe = $recipe;
        return $this;
    }
}
