<?php

namespace App\Controller;

use App\Manager\IngredientManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/ingredient")
 */
class IngredientController extends AbstractController
{

    /** @var IngredientManager */
    private IngredientManager $manager;

    public function __construct(IngredientManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/all", name="get_all_ingredients")
     */
    public function index(): JsonResponse
    {
        return $this->json($this->manager->findAll());
    }
}
