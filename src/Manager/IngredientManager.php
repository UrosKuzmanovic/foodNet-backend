<?php

namespace App\Manager;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;

class IngredientManager
{

    /** @var IngredientRepository */
    private IngredientRepository $repository;

    public function __construct(IngredientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Ingredient[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

}