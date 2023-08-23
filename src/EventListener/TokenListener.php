<?php

namespace App\EventListener;

use App\Service\Microservices\AuthenticatorService;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TokenListener
{

    private AuthenticatorService $authService;

    private const SKIP_URI_ARRAY = [
        '/api/foodnet/auth/login',
        '/api/foodnet/auth/register',
        '/api/foodnet/auth/confirm',
        '/api/foodnet/auth/google-login',
        '/api/foodnet/auth/google-verify',
    ];

    public function __construct(
        AuthenticatorService $authService
    )
    {
        $this->authService = $authService;
    }

    /**
     * @throws Exception
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $requestUri = $event->getRequest()->getRequestUri();
        if (!in_array($requestUri, self::SKIP_URI_ARRAY)) {
            $token = $event->getRequest()->headers->get('Authorization');
            $this->authService->setToken($token);

            if (!$token) {
                $this->authService->setToken('');
                throw new HttpException(Response::HTTP_UNAUTHORIZED, 'user not found');
            } else {
                $user = ($this->authService->get('user'))->getUser();

                if ($user && $user->getId()) {
                    $this->authService->setUser($user);
                } else {
                    $this->authService->setToken('');
                    throw new HttpException(Response::HTTP_UNAUTHORIZED, 'user not found');
                }
            }
        }
    }
}