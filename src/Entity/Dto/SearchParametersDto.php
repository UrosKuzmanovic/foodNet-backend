<?php

namespace App\Entity\Dto;

class SearchParametersDto
{
    private ?int $authorId = null;

    private ?bool $archived = false;

    private ?string $search = null;

    /**
     * @return int|null
     */
    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }

    /**
     * @param int|null $authorId
     * @return SearchParametersDto
     */
    public function setAuthorId(?int $authorId): SearchParametersDto
    {
        $this->authorId = $authorId;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    /**
     * @param bool|null $archived
     * @return SearchParametersDto
     */
    public function setArchived(?bool $archived): SearchParametersDto
    {
        $this->archived = $archived;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * @param string|null $search
     * @return SearchParametersDto
     */
    public function setSearch(?string $search): SearchParametersDto
    {
        $this->search = $search;
        return $this;
    }
}