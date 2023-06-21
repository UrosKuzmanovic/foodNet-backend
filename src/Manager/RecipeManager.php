<?php

namespace App\Manager;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;

class RecipeManager
{

    /** @var RecipeRepository */
    private RecipeRepository $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Recipe[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

}