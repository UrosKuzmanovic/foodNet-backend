<?php

namespace App\Controller;

use App\Entity\Dto\SearchParametersDto;
use App\Entity\Recipe;
use App\Manager\RecipeManager;
use App\Service\ImageService;
use App\Service\Microservices\AnalyticsService;
use App\Service\Microservices\AuthenticatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/foodnet/recipe")
 */
class RecipeController extends AbstractController
{

    private AuthenticatorService $authService;
    private RecipeManager $manager;
    private ImageService $imageService;
    private AnalyticsService $analyticsService;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(
        AuthenticatorService $authService,
        RecipeManager        $manager,
        ImageService         $imageService,
        AnalyticsService     $analyticsService,
        SerializerInterface  $serializer,
        ValidatorInterface   $validator
    )
    {
        $this->authService = $authService;
        $this->manager = $manager;
        $this->imageService = $imageService;
        $this->analyticsService = $analyticsService;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/list", methods={"POST"}, name="get_all_recipes")
     */
    public function list(Request $request): JsonResponse
    {
        /** @var SearchParametersDto $parameters */
        $parameters = $this->serializer->deserialize($request->getContent(), SearchParametersDto::class, 'json');

        return $this->json([
            'status' => Response::HTTP_OK,
            'items' => $this->manager->findForFeed($parameters),
        ], Response::HTTP_OK, [], ['groups' => ['list', 'recipe_serialization']]);
    }

    /**
     * @Route("", methods={"POST"}, name="add_recipe")
     */
    public function add(Request $request): JsonResponse
    {
        $content = $request->getContent();

        /** @var Recipe $recipe */
        $recipe = $this->serializer->deserialize($content, Recipe::class, 'json');

        $recipe->setImage($this->imageService->saveImage(json_decode($content)->base64Image));

        if (count($valid = $this->validator->validate($recipe)) > 0) {
            return $this->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Recipe not valid',
                'not_valid' => $valid
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->analyticsService->sendAnalytics(
            'Create',
            'Add Recipe',
            Recipe::class,
            $recipe->getId()
        );

        return $this->json([
            'status' => Response::HTTP_OK,
            'message' => 'Recipe saved!',
            'recipe' => $this->manager->save($recipe),
        ]);
    }

    /**
     * @Route("", methods={"PUT"}, name="update_recipe")
     */
    public function update(Request $request): JsonResponse
    {
        /** @var Recipe $recipe */
        $recipe = $this->serializer->deserialize($request->getContent(), Recipe::class, 'json');

        if ($recipe->getId()) {
            if (count($this->validator->validate($recipe)) > 0 || !$recipeDB = $this->manager->update($recipe)) {
                return $this->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Recipe not valid',
                ], Response::HTTP_BAD_REQUEST);
            }

            $this->analyticsService->sendAnalytics(
                'Edit',
                'Edit Recipe',
                Recipe::class,
                $recipe->getId()
            );

            return $this->json([
                'status' => Response::HTTP_OK,
                'message' => 'Recipe updated!',
                'recipe' => $recipeDB,
            ], Response::HTTP_OK, [], ['groups' => ['list', 'recipe_serialization']]);
        }

        return $this->json([
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => 'Recipe not valid',
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete_recipe")
     */
    public function deleteRecipe(int $id): JsonResponse
    {
        $this->analyticsService->sendAnalytics(
            'Delete',
            'Delete Recipe',
            Recipe::class,
            $id
        );

        return $this->json([
            'id' => $this->manager->delete($id)
        ], Response::HTTP_OK
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get_recipe")
     */
    public function getRecipe(int $id): JsonResponse
    {
        return $this->json(
            $this->manager->findById($id),
            Response::HTTP_OK, [], ['groups' => ['list', 'recipe_serialization']]
        );
    }
}
