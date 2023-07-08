<?php

namespace App\Controller;

use App\Manager\AuthorManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/author")
 */
class AuthorController extends AbstractController
{

    /** @var AuthorManager */
    private AuthorManager $manager;

    public function __construct(AuthorManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/all", name="get_all_authors")
     */
    public function getAll(): JsonResponse
    {
        return $this->json($this->manager->findAll());
    }
}
