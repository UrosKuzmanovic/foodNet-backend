<?php

namespace App\Entity\Dto;

class SmsSentDto
{

    private ?int $id;

    private ?string $fromNumber;

    private ?string $toNumber;

    private ?string $text;

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
     * @return SmsSentDto
     */
    public function setId(?int $id): SmsSentDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFromNumber(): ?string
    {
        return $this->fromNumber;
    }

    /**
     * @param string|null $fromNumber
     * @return SmsSentDto
     */
    public function setFromNumber(?string $fromNumber): SmsSentDto
    {
        $this->fromNumber = $fromNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getToNumber(): ?string
    {
        return $this->toNumber;
    }

    /**
     * @param string|null $toNumber
     * @return SmsSentDto
     */
    public function setToNumber(?string $toNumber): SmsSentDto
    {
        $this->toNumber = $toNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return SmsSentDto
     */
    public function setText(?string $text): SmsSentDto
    {
        $this->text = $text;
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
     * @return SmsSentDto
     */
    public function setTime(?\DateTime $time): SmsSentDto
    {
        $this->time = $time;
        return $this;
    }
}