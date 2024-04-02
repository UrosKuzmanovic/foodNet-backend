<?php

namespace App\EventListener\Events;


use App\Entity\Dto\AnalyticsDto;

class SendAnalyticsEvent
{

    private AnalyticsDto $analyticsDto;

    public function __construct(AnalyticsDto $analyticsDto)
    {
        $this->analyticsDto = $analyticsDto;
    }

    /**
     * @return AnalyticsDto
     */
    public function getAnalyticsDto(): AnalyticsDto
    {
        return $this->analyticsDto;
    }
}