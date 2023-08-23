<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Dto\AnalyticsDto;
use App\Entity\Dto\SmsSentDto;
use App\EventListener\Events\SendAnalyticsEvent;
use App\Manager\AuthorManager;
use App\Service\Microservices\AnalyticsService;
use App\Service\Microservices\AuthenticatorService;
use App\Service\Microservices\SmsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/api/foodnet/auth")
 */
class AuthController extends AbstractController
{

    private AuthorManager $authorManager;
    private AuthenticatorService $authenticatorService;
    private SmsService $smsService;
    private AnalyticsService $analyticsService;

    public function __construct(
        AuthorManager        $authorManager,
        AuthenticatorService $authenticatorService,
        SmsService $smsService,
        AnalyticsService     $analyticsService
    )
    {
        $this->authorManager = $authorManager;
        $this->authenticatorService = $authenticatorService;
        $this->smsService = $smsService;
        $this->analyticsService = $analyticsService;
    }

    /**
     * @Route("/register", name="register_authors")
     */
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());
        $data->enabled = false;

        $httpDto = $this->authenticatorService->post('register', json_encode($data));

        if ($httpDto->getStatus() === Response::HTTP_OK && $user = $httpDto->getUser()) {
            $authorDB = $this->authorManager->registerAuthor($user);

            $this->analyticsService->sendAnalytics(
                'Signup',
                'User Registration',
                Author::class,
                $authorDB->getId()
            );

            // TODO enable sms
//            $this->smsService->post(
//                (new SmsSentDto())
//                    ->setToNumber('')
//                    ->setText('Your confirmation code is ' . $user->getConfirmationCode())
//            );

            return $this->json([
                'status' => $httpDto->getStatus(),
                'message' => 'Confirmation required',
                'author' => $authorDB,
            ],
                $httpDto->getStatus(),
                [],
                [AbstractNormalizer::GROUPS => ['list']]
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
     * @Route("/confirm", name="confirm_author")
     */
    public function confirm(Request $request): JsonResponse
    {
        $httpDto = $this->authenticatorService->post('confirm', $request->getContent());

        if ($httpDto->getStatus() === Response::HTTP_OK && $user = $httpDto->getUser()) {
            $authorDB = $this->authorManager->enableAuthor($user);

            $this->analyticsService->sendAnalytics(
                'Signup',
                'User Enabled',
                Author::class,
                $authorDB->getId()
            );

            return $this->json([
                'status' => $httpDto->getStatus(),
                'message' => 'Confirmation required',
                'author' => $authorDB,
                'token' => $httpDto->getToken()
            ],
                $httpDto->getStatus(),
                [],
                [AbstractNormalizer::GROUPS => ['list']]
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

        if ($httpDto->getStatus() === Response::HTTP_OK && ($user = $httpDto->getUser())) {
            $authorDB = $this->authorManager->getByUser($user);

            $this->analyticsService->sendAnalytics(
                'Login',
                'User Login',
                Author::class,
                $authorDB->getId()
            );

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
                $authorDB = (new Author())
                    ->setEmail($userDto->getEmail())
                    ->setUsername($userDto->getUsername())
                    ->setFirstName($userDto->getFirstName())
                    ->setLastName($userDto->getLastName())
                    ->setUserId($userDto->getId());

                $authorDB = $this->authorManager->save($authorDB);
            }

            $this->analyticsService->sendAnalytics(
                'Login',
                'User Google Login',
                Author::class,
                $authorDB->getId()
            );

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
            $this->analyticsService->sendAnalytics(
                'Logout',
                'User Logout',
                Author::class,
                $this->authenticatorService->getAuthor()->getId()
            );

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
