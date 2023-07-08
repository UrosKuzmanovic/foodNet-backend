<?php

namespace App\Manager;

use App\Entity\Author;
use App\Repository\AuthorRepository;

class AuthorManager
{

    /** @var AuthorRepository */
    private AuthorRepository $repository;

    public function __construct(AuthorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Author[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

}