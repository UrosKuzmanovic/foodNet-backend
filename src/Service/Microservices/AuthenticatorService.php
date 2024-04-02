<?php

namespace App\Service\Microservices;

use App\Entity\Author;
use App\Entity\Dto\AuthenticatorHttpDto;
use App\Entity\Dto\UserDto;
use App\Manager\AuthorManager;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AuthenticatorService
{

    private AuthorManager $authorManager;

    private SerializerInterface $serializer;
    private SessionInterface $session;

    private const BASE_URI = 'http://host.docker.internal';
    private const API = 'api/authenticator/';

    public function __construct(
        AuthorManager       $authorManager,
        SerializerInterface $serializer,
        SessionInterface    $session
    )
    {
        $this->authorManager = $authorManager;
        $this->serializer = $serializer;
        $this->session = $session;
    }

    /**
     * @return ?UserDto
     */
    public function getUser(): ?UserDto
    {
        return $this->session->get('_user');
    }

    /**
     * @param ?UserDto $user
     * @return void
     */
    public function setUser(?UserDto $user): void
    {
        $this->session->set('_user', $user);
    }

    /**
     * @return Author|null
     */
    public function getAuthor(): ?Author
    {
        if (!$userDto = $this->getUser()) {
            return null;
        }

        return $this->authorManager->findOneBy(['userId' => $userDto->getId()]);
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->session->get('_token');
    }

    /**
     * @param string|null $token
     * @return void
     */
    public function setToken(?string $token): void
    {
        $this->session->set('_token', $token);
    }

    /**
     * @param string $path
     * @return AuthenticatorHttpDto
     */
    public function get(string $path): AuthenticatorHttpDto
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        try {
            $response = $client->post(self::API . $path, [
                'headers' => [
                    'Authorization' => $this->getToken(),
                ]
            ]);

            $data = $response->getBody()->getContents();

            return $this->serializer->deserialize($data, AuthenticatorHttpDto::class, 'json');
        } catch (\Exception|GuzzleException $e) {
            return (new AuthenticatorHttpDto())
                ->setStatus($e->getCode())
                ->setMessage($e->getMessage());
        }
    }

    /**
     * @param string $path
     * @param $data
     * @return AuthenticatorHttpDto
     */
    public function post(string $path, $data): AuthenticatorHttpDto
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        $response = null;

        try {
            $response = $client->post(self::API . $path, [
                'headers' => [
                    'Authorization' => $this->getToken(),
                ],
                'body' => $data
            ]);

            $data = $response->getBody()->getContents();

            return $this->serializer->deserialize($data, AuthenticatorHttpDto::class, 'json');
        } catch (\Exception|GuzzleException $e) {
            return (new AuthenticatorHttpDto())
                ->setStatus($e->getCode())
                ->setMessage($e->getMessage());
        }
    }

    /**
     * @return string
     * @throws GuzzleException
     */
    public function googleLogin()
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        $response = $client->post(self::API . 'google/permission', [
            'headers' => [
                'Authorization' => $this->getToken(),
            ],
            'body' => json_encode([
                'url' => 'http://localhost/' . self::API . 'login'
            ]),
        ]);

        return $response->getBody()->getContents();
    }
}