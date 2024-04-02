<?php

namespace App\Entity\Dto;

class AnalyticsDto
{

    private ?int $id;

    private ?string $event;

    private ?string $name;

    private ?int $userId;

    private ?string $entity;

    private ?int $entityId;

    private ?string $additionalData;

    private ?\DateTime $time;

    /**
     * @param string|null $event
     * @param string|null $name
     * @param string|null $entity
     * @param string|null $entityId
     * @param string|null $additionalData
     * @return AnalyticsDto
     */
    public static function getAnalytics(
        ?string $event,
        ?string $name,
        ?string $entity,
        ?string $entityId,
        ?string $additionalData
    ): AnalyticsDto
    {
        return (new self())
            ->setEvent($event)
            ->setName($name)
            ->setEntity($entity)
            ->setEntityId($entityId)
            ->setAdditionalData($additionalData);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return AnalyticsDto
     */
    public function setId(?int $id): AnalyticsDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEvent(): ?string
    {
        return $this->event;
    }

    /**
     * @param string|null $event
     * @return AnalyticsDto
     */
    public function setEvent(?string $event): AnalyticsDto
    {
        $this->event = $event;
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
     * @return AnalyticsDto
     */
    public function setName(?string $name): AnalyticsDto
    {
        $this->name = $name;
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
     * @return AnalyticsDto
     */
    public function setUserId(?int $userId): AnalyticsDto
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
     * @return AnalyticsDto
     */
    public function setEntity(?string $entity): AnalyticsDto
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
     * @return AnalyticsDto
     */
    public function setEntityId(?int $entityId): AnalyticsDto
    {
        $this->entityId = $entityId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditionalData(): ?string
    {
        return $this->additionalData;
    }

    /**
     * @param string|null $additionalData
     * @return AnalyticsDto
     */
    public function setAdditionalData(?string $additionalData): AnalyticsDto
    {
        $this->additionalData = $additionalData;
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
     * @return AnalyticsDto
     */
    public function setTime(?\DateTime $time): AnalyticsDto
    {
        $this->time = $time;
        return $this;
    }

}