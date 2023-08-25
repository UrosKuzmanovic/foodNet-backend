<?php

namespace App\Entity\Dto\Reviews;

class RatingDto
{
    private ?int $id;

    private ?int $userId;

    private ?string $entity;

    private ?int $entityId;

    private ?float $rating;

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
     * @return RatingDto
     */
    public function setId(?int $id): RatingDto
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
     * @return RatingDto
     */
    public function setUserId(?int $userId): RatingDto
    {
        $this->userId = $userId;
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
     * @return RatingDto
     */
    public function setEntity(?string $entity): RatingDto
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
     * @return RatingDto
     */
    public function setEntityId(?int $entityId): RatingDto
    {
        $this->entityId = $entityId;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getRating(): ?float
    {
        return $this->rating;
    }

    /**
     * @param float|null $rating
     * @return RatingDto
     */
    public function setRating(?float $rating): RatingDto
    {
        $this->rating = $rating;
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
     * @return RatingDto
     */
    public function setTime(?\DateTime $time): RatingDto
    {
        $this->time = $time;
        return $this;
    }
}