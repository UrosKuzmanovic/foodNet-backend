<?php

namespace App\Controller;

use App\Manager\TagManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/tag")
 */
class TagController extends AbstractController
{

    /** @var TagManager */
    private TagManager $manager;

    public function __construct(TagManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/all", name="get_all_tags")
     */
    public function getAll(): JsonResponse
    {
        return $this->json($this->manager->findAll());
    }
}
