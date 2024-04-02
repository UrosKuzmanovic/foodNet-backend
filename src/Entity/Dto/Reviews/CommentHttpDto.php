<?php

namespace App\Entity\Dto\Reviews;

use App\Entity\Dto\MicroserviceHttpDto;

class CommentHttpDto extends MicroserviceHttpDto
{

    /** @var CommentDto[] $comments */
    private array $comments;

    public function __construct()
    {
        $this->comments = [];
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param array $comments
     * @return CommentHttpDto
     */
    public function setComments(array $comments): CommentHttpDto
    {
        $this->comments = $comments;
        return $this;
    }
}