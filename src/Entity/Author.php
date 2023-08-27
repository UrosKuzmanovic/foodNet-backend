<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"list"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list"})
     */
    private ?string $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list"})
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list"})
     */
    private ?string $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list"})
     */
    private ?string $lastName;

    /**
     * @ORM\Column(type="integer", nullable=true, unique=true)
     * @Groups({"list"})
     */
    private ?int $userId;

//    /**
//     * @var Recipe[]|Collection
//     * @ORM\OneToMany(targetEntity=Recipe::class, mappedBy="author")
//     * @Groups({"author_serialization"})
//     */
//    private Collection $recipes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"list"})
     */
    private bool $enabled = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureUrl;

    public function __construct()
    {
//        $this->recipes = new ArrayCollection();
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
     * @return Author
     */
    public function setId(int $id): Author
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return Author
     */
    public function setUsername(?string $username): Author
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Author
     */
    public function setEmail(?string $email): Author
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return Author
     */
    public function setFirstName(?string $firstName): Author
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return Author
     */
    public function setLastName(?string $lastName): Author
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     * @return Author
     */
    public function setUserId(?int $userId): Author
    {
        $this->userId = $userId;
        return $this;
    }
//
//    /**
//     * @return Collection
//     */
//    public function getRecipes(): Collection
//    {
//        return $this->recipes;
//    }
//
//    /**
//     * @param Collection $recipes
//     * @return Author
//     */
//    public function setRecipes(Collection $recipes): Author
//    {
//        $this->recipes = $recipes;
//        return $this;
//    }
//
//    /**
//     * @param Recipe $recipe
//     */
//    public function addRecipe(Recipe $recipe)
//    {
//        $this->recipes->add($recipe);
//        $recipe->setAuthor($this);
//    }
//
//    /**
//     * @param Recipe $recipe
//     */
//    public function removeRecipe(Recipe $recipe)
//    {
//        $this->recipes->removeElement($recipe);
//        $recipe->setAuthor(null);
//    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return Author
     */
    public function setEnabled(bool $enabled): Author
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    public function setPictureUrl(?string $pictureUrl): self
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

}
