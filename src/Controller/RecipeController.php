<?php

namespace App\Controller;

use App\Manager\RecipeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/recipe")
 */
class RecipeController extends AbstractController
{

    /** @var RecipeManager */
    private RecipeManager $manager;

    public function __construct(RecipeManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/all", name="get_all_recipes")
     */
    public function index(): JsonResponse
    {
        return $this->json($this->manager->findAll());
    }
}
