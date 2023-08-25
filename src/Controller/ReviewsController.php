<?php

namespace App\Controller;

use App\Entity\Dto\Reviews\CommentDto;
use App\Entity\Recipe;
use App\Service\Microservices\AuthenticatorService;
use App\Service\Microservices\ReviewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/foodnet/reviews")
 */
class ReviewsController extends AbstractController
{

    private ReviewsService $reviewsService;
    private AuthenticatorService $authenticatorService;
    private SerializerInterface $serializer;

    public function __construct(
        ReviewsService       $reviewsService,
        AuthenticatorService $authenticatorService,
        SerializerInterface  $serializer
    )
    {
        $this->reviewsService = $reviewsService;
        $this->authenticatorService = $authenticatorService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/comment/send", name="send_comments")
     */
    public function sendComments(Request $request): JsonResponse
    {
        $author = $this->authenticatorService->getAuthor();

        /** @var CommentDto $commentsArray */
        $comment = $this->serializer->deserialize($request->getContent(), CommentDto::class, 'json');

        $comment
            ->setUserId($author->getId())
            ->setName($author->getFirstName() . ' ' . $author->getLastName())
            ->setEmail($author->getEmail())
            ->setEntity(Recipe::class);

        $commentsDto = $this->reviewsService->postComment($comment, 'add');

        return $this->json([
            'status' => $commentsDto->getStatus(),
            'message' => $commentsDto->getMessage(),
            'comments' => $commentsDto->getComments(),
        ]);
    }

    /**
     * @Route("/comment/get", name="get_comments")
     */
    public function getComments(Request $request): JsonResponse
    {
        /** @var CommentDto $comment */
        $comment = $this->serializer->deserialize($request->getContent(), CommentDto::class, 'json');
        $comment->setEntity(Recipe::class);

        if ($comment->getEntity() && $comment->getEntityId()) {
            $commentsDto = $this->reviewsService->postComment($comment, 'get');

            return $this->json([
                'status' => $commentsDto->getStatus(),
                'message' => $commentsDto->getMessage(),
                'comments' => $commentsDto->getComments(),
            ], Response::HTTP_OK);
        }

        return $this->json([
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => 'Error while fetching comments'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
