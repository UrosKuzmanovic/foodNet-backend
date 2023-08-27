<?php

namespace App\Service\Microservices;

use App\Entity\Author;
use App\Entity\Dto\AnalyticsDto;
use App\Entity\Dto\AnalyticsHttpDto;
use App\Entity\Dto\Email\EmailHttpDto;
use App\Entity\Dto\Email\EmailSentDto;
use App\EventListener\Events\SendAnalyticsEvent;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class EmailService
{

    private SerializerInterface $serializer;

    private const BASE_URI = 'http://host.docker.internal';
    private const API = 'api/email/';

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    /**
     * @param EmailSentDto $data
     * @param string $path
     * @return EmailHttpDto
     */
    public function post(EmailSentDto $data, string $path = 'send'): EmailHttpDto
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        try {
            $response = $client->post(self::API . $path, [
                'body' => $this->serializer->serialize($data, 'json')
            ]);

            $responseData = $response->getBody()->getContents();

            return $this->serializer->deserialize($responseData, EmailHttpDto::class, 'json');
        } catch (\Exception|GuzzleException $e) {
            return (new EmailHttpDto())
                ->setStatus($e->getCode())
                ->setMessage($e->getMessage());
        }
    }
}