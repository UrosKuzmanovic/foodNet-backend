<?php

namespace App\Service\Microservices;

use App\Entity\Author;
use App\Entity\Dto\AnalyticsDto;
use App\Entity\Dto\AnalyticsHttpDto;
use App\EventListener\Events\SendAnalyticsEvent;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class AnalyticsService
{

    private SerializerInterface $serializer;

    private EventDispatcherInterface $dispatcher;

    private const BASE_URI = 'http://host.docker.internal';
    private const API = 'api/analytics/';

    public function __construct(
        SerializerInterface      $serializer,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->serializer = $serializer;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param string $path
     * @return AnalyticsHttpDto
     */
    public function get(string $path): AnalyticsHttpDto
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        try {
            $response = $client->post(self::API . $path);

            $data = $response->getBody()->getContents();

            return $this->serializer->deserialize($data, AnalyticsHttpDto::class, 'json');
        } catch (\Exception|GuzzleException $e) {
            return (new AnalyticsHttpDto())
                ->setStatus($e->getCode())
                ->setMessage($e->getMessage());
        }
    }

    /**
     * @param AnalyticsDto $data
     * @param string $path
     * @return AnalyticsHttpDto
     */
    public function post(AnalyticsDto $data, string $path = 'action/send'): AnalyticsHttpDto
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        try {
            $response = $client->post(self::API . $path, [
                'body' => $this->serializer->serialize($data, 'json')
            ]);

            $responseData = $response->getBody()->getContents();

            return $this->serializer->deserialize($responseData, AnalyticsHttpDto::class, 'json');
        } catch (\Exception|GuzzleException $e) {
            return (new AnalyticsHttpDto())
                ->setStatus($e->getCode())
                ->setMessage($e->getMessage());
        }
    }

    /**
     * @param string|null $event
     * @param string|null $name
     * @param string|null $entity
     * @param int|null $entityId
     * @param string|null $additionalData
     * @return object
     */
    public function sendAnalytics(?string $event, ?string $name, ?string $entity, ?int $entityId, ?string $additionalData = null): object
    {
        return $this->dispatcher->dispatch(
            new SendAnalyticsEvent(
                AnalyticsDto::getAnalytics($event, $name, $entity, $entityId, $additionalData)),
            SendAnalyticsEvent::class
        );
    }
}