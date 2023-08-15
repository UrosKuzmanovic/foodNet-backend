<?php

namespace App\Controller;

use App\Entity\Author;
use App\Manager\AuthorManager;
use App\Service\Microservices\AuthenticatorService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * @Route("/api/foodnet/author")
 */
class AuthorController extends AbstractController
{
    private AuthorManager $manager;

    public function __construct(
        AuthorManager $manager
    )
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/{id}", name="get_author")
     */
    public function googleLogin(Request $request): JsonResponse
    {
        $id = intval($request->get('id'));

        $authorDB = $this->manager->findOneBy(['id' => $id]);

        if(!$authorDB) {
            return $this->json(
                [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'Author not found',
                ]
            );
        }

        $metadata['count'] = $this->manager->getRecipesCountForAuthor($authorDB);

        return $this->json(
            [
                'status' => Response::HTTP_OK,
                'message' => 'Author',
                'author' => $authorDB,
                'metadata' => $metadata,
            ]
        );
    }
}
