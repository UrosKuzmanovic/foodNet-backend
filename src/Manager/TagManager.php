<?php

namespace App\Manager;

use App\Entity\Tag;
use App\Repository\TagRepository;

class TagManager
{

    /** @var TagRepository */
    private TagRepository $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Tag[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

}