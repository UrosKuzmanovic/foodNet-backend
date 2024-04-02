<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
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
     * @Groups({"list"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list"})
     */
    private ?string $color;

    /**
     * @ORM\ManyToOne(targetEntity=Recipe::class, inversedBy="tags")
     * @Groups({"tag_serialization"})
     */
    private ?Recipe $recipe;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Tag
     */
    public function setId(int $id): Tag
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
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string|null $color
     * @return $this
     */
    public function setColor(?string $color): self
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return Recipe|null
     */
    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    /**
     * @param Recipe|null $recipe
     * @return $this
     */
    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;
        return $this;
    }
}
