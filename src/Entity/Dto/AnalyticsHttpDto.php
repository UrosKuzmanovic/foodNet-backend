<?php

namespace App\Entity\Dto;

class AnalyticsHttpDto extends MicroserviceHttpDto
{

    private array $data;

    public function __construct()
    {
        $this->data = [];
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return AnalyticsHttpDto
     */
    public function setData(array $data): AnalyticsHttpDto
    {
        $this->data = $data;
        return $this;
    }
}