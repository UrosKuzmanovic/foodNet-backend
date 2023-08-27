<?php

namespace App\Entity\Dto\Email;

use App\Entity\Dto\MicroserviceHttpDto;

class EmailHttpDto extends MicroserviceHttpDto
{

    private ?EmailSentDto $emailSent;

    /**
     * @return EmailSentDto|null
     */
    public function getEmailSent(): ?EmailSentDto
    {
        return $this->emailSent;
    }

    /**
     * @param EmailSentDto|null $emailSent
     * @return EmailHttpDto
     */
    public function setEmailSent(?EmailSentDto $emailSent): EmailHttpDto
    {
        $this->emailSent = $emailSent;
        return $this;
    }
}