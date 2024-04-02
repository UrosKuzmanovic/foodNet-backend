<?php

namespace App\Service\Microservices;

use App\Entity\Dto\AnalyticsDto;
use App\Entity\Dto\SmsHttpDto;
use App\Entity\Dto\SmsSentDto;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Serializer\SerializerInterface;

class SmsService
{

    private SerializerInterface $serializer;

    private const BASE_URI = 'http://host.docker.internal';
    private const API = 'api/sms/';

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    /**
     * @param string $path
     * @return SmsHttpDto
     */
    public function get(string $path): SmsHttpDto
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        try {
            $response = $client->post(self::API . $path);

            $data = $response->getBody()->getContents();

            return $this->serializer->deserialize($data, SmsHttpDto::class, 'json');
        } catch (\Exception|GuzzleException $e) {
            return (new SmsHttpDto())
                ->setStatus($e->getCode())
                ->setMessage($e->getMessage());
        }
    }

    /**
     * @param SmsSentDto $data
     * @param string $path
     * @return SmsHttpDto
     */
    public function post(SmsSentDto $data, string $path = 'send'): SmsHttpDto
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        try {
            $response = $client->post(self::API . $path, [
                'body' => $this->serializer->serialize($data, 'json')
            ]);

            $responseData = $response->getBody()->getContents();

            return $this->serializer->deserialize($responseData, SmsHttpDto::class, 'json');
        } catch (\Exception|GuzzleException $e) {
            return (new SmsHttpDto())
                ->setStatus($e->getCode())
                ->setMessage($e->getMessage());
        }
    }
}