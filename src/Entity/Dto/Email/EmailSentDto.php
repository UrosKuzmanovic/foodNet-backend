<?php

namespace App\Entity\Dto\Email;

class EmailSentDto
{

    private ?int $id;

    private ?string $from;

    private ?string $fromEmail;

    private ?string $to;

    private ?string $toEmail;

    private ?string $subject;

    private ?string $text;

    private ?\DateTime $sentAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return EmailSentDto
     */
    public function setId(?int $id): EmailSentDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * @param string|null $from
     * @return EmailSentDto
     */
    public function setFrom(?string $from): EmailSentDto
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFromEmail(): ?string
    {
        return $this->fromEmail;
    }

    /**
     * @param string|null $fromEmail
     * @return EmailSentDto
     */
    public function setFromEmail(?string $fromEmail): EmailSentDto
    {
        $this->fromEmail = $fromEmail;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTo(): ?string
    {
        return $this->to;
    }

    /**
     * @param string|null $to
     * @return EmailSentDto
     */
    public function setTo(?string $to): EmailSentDto
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getToEmail(): ?string
    {
        return $this->toEmail;
    }

    /**
     * @param string|null $toEmail
     * @return EmailSentDto
     */
    public function setToEmail(?string $toEmail): EmailSentDto
    {
        $this->toEmail = $toEmail;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string|null $subject
     * @return EmailSentDto
     */
    public function setSubject(?string $subject): EmailSentDto
    {
        $this->subject = $subject;
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
     * @return EmailSentDto
     */
    public function setText(?string $text): EmailSentDto
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getSentAt(): ?\DateTime
    {
        return $this->sentAt;
    }

    /**
     * @param \DateTime|null $sentAt
     * @return EmailSentDto
     */
    public function setSentAt(?\DateTime $sentAt): EmailSentDto
    {
        $this->sentAt = $sentAt;
        return $this;
    }
}