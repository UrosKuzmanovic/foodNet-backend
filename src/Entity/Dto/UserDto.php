<?php

namespace App\Entity\Dto;

use App\Entity\Image;

class UserDto
{
    private ?int $id = null;

    private ?string $email = null;

    private array $roles = [];

    private ?string $username = null;

    private ?string $password = null;

    private ?string $firstName = null;

    private ?string $lastName = null;

    private ?string $name = null;

    private ?string $pictureUrl = null;

    private bool $enabled = true;

    private bool $locked = false;

    private ?string $googleId = null;

    private ?\DateTime $createdAt = null;

    private ?\DateTime $updatedAt = null;

    private ?\DateTime $loggedAt = null;

    private ?string $confirmationCode = null;

    private ?Image $image = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return UserDto
     */
    public function setId(?int $id): UserDto
    {
        $this->id = $id;
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
     * @return UserDto
     */
    public function setEmail(?string $email): UserDto
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return UserDto
     */
    public function setRoles(array $roles): UserDto
    {
        $this->roles = $roles;
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
     * @return UserDto
     */
    public function setUsername(?string $username): UserDto
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return UserDto
     */
    public function setPassword(?string $password): UserDto
    {
        $this->password = $password;
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
     * @return UserDto
     */
    public function setFirstName(?string $firstName): UserDto
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
     * @return UserDto
     */
    public function setLastName(?string $lastName): UserDto
    {
        $this->lastName = $lastName;
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
     * @return UserDto
     */
    public function setName(?string $name): UserDto
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    /**
     * @param string|null $pictureUrl
     * @return UserDto
     */
    public function setPictureUrl(?string $pictureUrl): UserDto
    {
        $this->pictureUrl = $pictureUrl;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return UserDto
     */
    public function setEnabled(bool $enabled): UserDto
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->locked;
    }

    /**
     * @param bool $locked
     * @return UserDto
     */
    public function setLocked(bool $locked): UserDto
    {
        $this->locked = $locked;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    /**
     * @param string|null $googleId
     * @return UserDto
     */
    public function setGoogleId(?string $googleId): UserDto
    {
        $this->googleId = $googleId;
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
     * @return UserDto
     */
    public function setCreatedAt(?\DateTime $createdAt): UserDto
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
     * @return UserDto
     */
    public function setUpdatedAt(?\DateTime $updatedAt): UserDto
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLoggedAt(): ?\DateTime
    {
        return $this->loggedAt;
    }

    /**
     * @param \DateTime|null $loggedAt
     * @return UserDto
     */
    public function setLoggedAt(?\DateTime $loggedAt): UserDto
    {
        $this->loggedAt = $loggedAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getConfirmationCode(): ?string
    {
        return $this->confirmationCode;
    }

    /**
     * @param string|null $confirmationCode
     * @return UserDto
     */
    public function setConfirmationCode(?string $confirmationCode): UserDto
    {
        $this->confirmationCode = $confirmationCode;
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
     * @return UserDto
     */
    public function setImage(?Image $image): UserDto
    {
        $this->image = $image;
        return $this;
    }
}