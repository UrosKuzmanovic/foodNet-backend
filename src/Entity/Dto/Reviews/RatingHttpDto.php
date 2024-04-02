<?php

namespace App\Entity\Dto\Reviews;

use App\Entity\Dto\MicroserviceHttpDto;

class RatingHttpDto extends MicroserviceHttpDto
{

    private ?RatingDto $rating = null;

    /**
     * @return RatingDto|null
     */
    public function getRating(): ?RatingDto
    {
        return $this->rating;
    }

    /**
     * @param RatingDto|null $rating
     * @return RatingHttpDto
     */
    public function setRating(?RatingDto $rating): RatingHttpDto
    {
        $this->rating = $rating;
        return $this;
    }
}