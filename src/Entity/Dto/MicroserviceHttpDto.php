<?php

namespace App\Entity\Dto;

class MicroserviceHttpDto
{
    private ?int $status = null;

    private ?string $message = null;

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     * @return MicroserviceHttpDto
     */
    public function setStatus(?int $status): MicroserviceHttpDto
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return MicroserviceHttpDto
     */
    public function setMessage(?string $message): MicroserviceHttpDto
    {
        $this->message = $message;
        return $this;
    }
}