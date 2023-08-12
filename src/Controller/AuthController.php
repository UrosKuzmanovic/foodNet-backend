<?php

namespace App\Controller;

use App\Entity\Author;
use App\Manager\AuthorManager;
use App\Service\Microservices\AuthenticatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * @Route("/api/foodnet/auth")
 */
class AuthController extends AbstractController
{

    private AuthorManager $authorManager;
    private AuthenticatorService $authenticatorService;

    public function __construct(
        AuthorManager        $authorManager,
        AuthenticatorService $authenticatorService
    )
    {
        $this->authorManager = $authorManager;
        $this->authenticatorService = $authenticatorService;
    }

    /**
     * @Route("/register", name="register_authors")
     */
    public function register(Request $request): JsonResponse
    {
        $httpDto = $this->authenticatorService->post('register', $request->getContent());

        if ($httpDto->getStatus() === Response::HTTP_OK && $user = $httpDto->getUser()) {
            $authorDB = $this->authorManager->registerAuthor($user);

            return $this->json([
                'status' => $httpDto->getStatus(),
                'message' => 'Author registered',
                'author' => $authorDB,
            ],
                $httpDto->getStatus(),
                [AbstractNormalizer::GROUPS => ['view']]
            );
        } else {
            return $this->json(
                array(
                    'status' => $httpDto->getStatus(),
                    'message' => $httpDto->getMessage()
                ),
                $httpDto->getStatus()
            );
        }
    }

    /**
     * @Route("/login", name="login_authors")
     */
    public function login(Request $request): JsonResponse
    {
        $httpDto = $this->authenticatorService->post('login', $request->getContent());

        if ($httpDto->getStatus() === Response::HTTP_OK && $user = $httpDto->getUser()) {
            $authorDB = $this->authorManager->getByUser($user);

            return $this->json(
                [
                    'status' => $httpDto->getStatus(),
                    'message' => 'Author logged in!',
                    'author' => $authorDB,
                    'token' => $httpDto->getToken()
                ],
                $httpDto->getStatus(), [], [AbstractNormalizer::GROUPS => ['list']]
            );
        } else {
            return $this->json(
                array(
                    'status' => $httpDto->getStatus(),
                    'message' => $httpDto->getMessage()
                ),
                $httpDto->getStatus()
            );
        }
    }

    /**
     * @Route("/google-login", name="google_auth")
     */
    public function googleLogin(Request $request): JsonResponse
    {
        return $this->json(
            [
                'status' => Response::HTTP_OK,
                'message' => 'Google login permission',
                'html' => $this->authenticatorService->googleLogin(),
            ]
        );
    }

    /**
     * @Route("/google-verify", name="google_auth_verify")
     */
    public function googleVerify(Request $request): JsonResponse
    {
        if ($userId = json_decode($request->getContent())->userId) {

            $authHttpDto = $this->authenticatorService->post('google/user', json_encode(['userId' => $userId]));
            $userDto = $authHttpDto->getUser();

            if (!$authorDB = $this->authorManager->findOneBy(['userId' => $userDto->getId()])) {
                $authorDB = new Author();
            }

            $authorDB
                ->setEmail($userDto->getEmail())
                ->setUsername($userDto->getUsername())
                ->setFirstName($userDto->getFirstName())
                ->setLastName($userDto->getLastName())
                ->setUserId($userDto->getId());

            $authorDB = $this->authorManager->save($authorDB);

            return $this->json(
                [
                    'status' => Response::HTTP_OK,
                    'message' => 'Google login success!',
                    'author' => $authorDB,
                    'token' => $authHttpDto->getToken(),
                ]
            );
        }

        return $this->json(
            [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Google login error',
            ]
        );
    }

    /**
     * @Route("/user", name="get_by_user")
     */
    public function getByUser(): JsonResponse
    {
        $httpDto = $this->authenticatorService->get('user');

        if ($httpDto->getStatus() === Response::HTTP_OK && $user = $httpDto->getUser()) {
            $authorDB = $this->authorManager->getByUser($user);

            return $this->json([
                'status' => $httpDto->getStatus(),
                'message' => 'Author fetched!',
                'author' => $authorDB
            ],
                $httpDto->getStatus(),
                [AbstractNormalizer::GROUPS => ['view']]
            );
        } else {
            return $this->json(
                array(
                    'status' => $httpDto->getStatus(),
                    'message' => $httpDto->getMessage()
                ),
                $httpDto->getStatus()
            );
        }
    }

    /**
     * @Route("/logout", name="logout_author")
     */
    public function logout(): JsonResponse
    {
        $httpDto = $this->authenticatorService->get('logout');

        if ($httpDto->getStatus() === Response::HTTP_OK) {
            return $this->json([
                'status' => $httpDto->getStatus(),
                'message' => 'Author logged out!',
                'author' => null,
            ],
                $httpDto->getStatus(),
                [AbstractNormalizer::GROUPS => ['view']]
            );
        } else {
            return $this->json(
                array(
                    'status' => $httpDto->getStatus(),
                    'message' => $httpDto->getMessage()
                ),
                $httpDto->getStatus()
            );
        }
    }
}
