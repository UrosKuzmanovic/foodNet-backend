<?php

namespace App\Manager;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use App\Service\UpdateService;

class RecipeManager
{

    /** @var RecipeRepository */
    private RecipeRepository $repository;
    private UpdateService $updateService;

    public function __construct(RecipeRepository $repository, UpdateService $updateService)
    {
        $this->repository = $repository;
        $this->updateService = $updateService;
    }

    /**
     * @return Recipe[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @return Recipe[]
     */
    public function findForFeed(): array
    {
        return $this->repository->findBy([
            'archived' => false,
            'deletedAt' => false
        ]);
    }

    /**
     * @param int $id
     * @return Recipe
     */
    public function findById(int $id): Recipe
    {
        return $this->repository->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @param Recipe $recipe
     * @return Recipe
     */
    public function save(Recipe $recipe): Recipe
    {
        return $this->repository->save($recipe);
    }

    /**
     * @param int $id
     * @return int|null
     */
    public function delete(int $id): ?int
    {
        if ($recipeDB = $this->findById($id)) {
            $recipeDB->setDeletedAt(new \DateTime());
            $this->save($recipeDB);

            return $recipeDB->getId();
        }

        return null;
    }

    /**
     * @param Recipe $recipe
     * @return Recipe
     */
    public function update(Recipe $recipe): Recipe
    {
        $recipeDB = $this->updateService->updateEntity($recipe);
        $recipeDB->setUpdatedAt(new \DateTime());

        return $this->save($recipeDB);
    }

}