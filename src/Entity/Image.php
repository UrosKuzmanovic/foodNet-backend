<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list"})
     */
    private ?string $path;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $fileSize;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $uploadedAt;

    /**
     * @ORM\OneToOne(targetEntity=Recipe::class, mappedBy="image", cascade={"persist", "remove"})
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
     * @param int|null $id
     * @return Image
     */
    public function setId(?int $id): Image
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
     * @return Image
     */
    public function setName(?string $name): Image
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     * @return Image
     */
    public function setPath(?string $path): Image
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    /**
     * @param int|null $fileSize
     * @return Image
     */
    public function setFileSize(?int $fileSize): Image
    {
        $this->fileSize = $fileSize;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUploadedAt(): ?\DateTime
    {
        return $this->uploadedAt;
    }

    /**
     * @param \DateTime|null $uploadedAt
     * @return Image
     */
    public function setUploadedAt(?\DateTime $uploadedAt): Image
    {
        $this->uploadedAt = $uploadedAt;
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
     * @return Image
     */
    public function setRecipe(?Recipe $recipe): Image
    {
        // unset the owning side of the relation if necessary
        if ($recipe === null && $this->recipe !== null) {
            $this->recipe->setImage(null);
        }

        // set the owning side of the relation if necessary
        if ($recipe !== null && $recipe->getImage() !== $this) {
            $recipe->setImage($this);
        }

        $this->recipe = $recipe;

        return $this;
    }
}
