<?php

namespace App\Manager;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use App\Service\Microservices\AuthenticatorService;
use App\Service\UpdateService;

class RecipeManager
{

    /** @var RecipeRepository */
    private RecipeRepository $repository;
    private UpdateService $updateService;
    private AuthenticatorService $authenticatorService;

    public function __construct(
        RecipeRepository $repository,
        UpdateService $updateService,
        AuthenticatorService $authenticatorService
    )
    {
        $this->repository = $repository;
        $this->updateService = $updateService;
        $this->authenticatorService = $authenticatorService;
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
            'deletedAt' => null
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
        if (!$recipe->getAuthor()) {
            $recipe->setAuthor($this->authenticatorService->getAuthor());
        }
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
        if ($recipeDB) {
            $recipeDB->setUpdatedAt(new \DateTime());

            return $this->save($recipeDB);
        }

        return new Recipe();
    }

}