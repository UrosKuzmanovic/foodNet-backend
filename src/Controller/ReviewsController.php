<?php

namespace App\Controller;

use App\Entity\Dto\Reviews\CommentDto;
use App\Entity\Dto\Reviews\RatingDto;
use App\Entity\Recipe;
use App\Service\Microservices\AnalyticsService;
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
    private AnalyticsService $analyticsService;
    private SerializerInterface $serializer;

    public function __construct(
        ReviewsService       $reviewsService,
        AuthenticatorService $authenticatorService,
        AnalyticsService     $analyticsService,
        SerializerInterface  $serializer
    )
    {
        $this->reviewsService = $reviewsService;
        $this->authenticatorService = $authenticatorService;
        $this->analyticsService = $analyticsService;
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

        $this->analyticsService->sendAnalytics(
            'Comment',
            'Recipe Comment',
            Recipe::class,
            $comment->getEntityId()
        );

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

    /**
     * @Route("/rating/add", name="add_rating")
     */
    public function addRating(Request $request): JsonResponse
    {
        $author = $this->authenticatorService->getAuthor();

        /** @var RatingDto $rating */
        $rating = $this->serializer->deserialize($request->getContent(), RatingDto::class, 'json');

        $rating
            ->setUserId($author->getId())
            ->setEntity(Recipe::class);

        $ratingHttpDto = $this->reviewsService->postRating($rating, 'add');

        $this->analyticsService->sendAnalytics(
            'Rating',
            'Recipe Rating',
            Recipe::class,
            $rating->getEntityId()
        );

        return $this->json([
            'status' => $ratingHttpDto->getStatus(),
            'message' => $ratingHttpDto->getMessage(),
        ]);
    }

    /**
     * @Route("/rating/get", name="get_rating")
     */
    public function getRating(Request $request): JsonResponse
    {
        $author = $this->authenticatorService->getAuthor();

        /** @var RatingDto $rating */
        $rating = $this->serializer->deserialize($request->getContent(), RatingDto::class, 'json');

        $rating
            ->setUserId($author->getId())
            ->setEntity(Recipe::class);

        $ratingHttpDto = $this->reviewsService->postRating($rating, 'get');

        return $this->json([
            'status' => $ratingHttpDto->getStatus(),
            'message' => $ratingHttpDto->getMessage(),
            'rating' => $ratingHttpDto->getRating(),
        ]);
    }

    /**
     * @Route("/rating/get-avg", name="get_avg_rating")
     */
    public function getAvgRating(Request $request): JsonResponse
    {
        $author = $this->authenticatorService->getAuthor();

        /** @var RatingDto $rating */
        $rating = $this->serializer->deserialize($request->getContent(), RatingDto::class, 'json');

        $rating
            ->setUserId($author->getId())
            ->setEntity(Recipe::class);

        $ratingHttpDto = $this->reviewsService->postRating($rating, 'get-avg');

        return $this->json([
            'status' => $ratingHttpDto->getStatus(),
            'message' => $ratingHttpDto->getMessage(),
            'rating' => $ratingHttpDto->getRating(),
        ]);
    }
}
