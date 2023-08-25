<?php

namespace App\Entity\Dto\Reviews;

class CommentDto
{
    private ?int $id;

    private ?int $userId;

    private ?string $name;

    private ?string $email;

    private ?string $entity;

    private ?int $entityId;

    private ?string $comment;

    private ?\DateTime $time;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return CommentDto
     */
    public function setId(?int $id): CommentDto
    {
        $this->id = $id;
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
     * @return CommentDto
     */
    public function setUserId(?int $userId): CommentDto
    {
        $this->userId = $userId;
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
     * @return CommentDto
     */
    public function setName(?string $name): CommentDto
    {
        $this->name = $name;
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
     * @return CommentDto
     */
    public function setEmail(?string $email): CommentDto
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEntity(): ?string
    {
        return $this->entity;
    }

    /**
     * @param string|null $entity
     * @return CommentDto
     */
    public function setEntity(?string $entity): CommentDto
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->entityId;
    }

    /**
     * @param int|null $entityId
     * @return CommentDto
     */
    public function setEntityId(?int $entityId): CommentDto
    {
        $this->entityId = $entityId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return CommentDto
     */
    public function setComment(?string $comment): CommentDto
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTime(): ?\DateTime
    {
        return $this->time;
    }

    /**
     * @param \DateTime|null $time
     * @return CommentDto
     */
    public function setTime(?\DateTime $time): CommentDto
    {
        $this->time = $time;
        return $this;
    }
}