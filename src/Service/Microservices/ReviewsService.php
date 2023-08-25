<?php

namespace App\Service\Microservices;

use App\Entity\Dto\Reviews\CommentHttpDto;
use App\Entity\Dto\Reviews\RatingHttpDto;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Serializer\SerializerInterface;

class ReviewsService
{

    private SerializerInterface $serializer;

    private const BASE_URI = 'http://host.docker.internal';
    private const API = 'api/reviews/';

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    /**
     * @param $data
     * @param string $path
     * @return CommentHttpDto
     */
    public function postComment($data, string $path): CommentHttpDto
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        try {
            $response = $client->post(self::API . 'comment/' . $path, [
                'body' => $this->serializer->serialize($data, 'json')
            ]);

            $responseData = $response->getBody()->getContents();

            return $this->serializer->deserialize($responseData, CommentHttpDto::class, 'json');
        } catch (\Exception|GuzzleException $e) {
            return (new CommentHttpDto())
                ->setStatus($e->getCode())
                ->setMessage($e->getMessage());
        }
    }

    /**
     * @param $data
     * @param string $path
     * @return RatingHttpDto
     */
    public function postRating($data, string $path): RatingHttpDto
    {
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        try {
            $response = $client->post(self::API . 'rating/' . $path, [
                'body' => $this->serializer->serialize($data, 'json')
            ]);

            $responseData = $response->getBody()->getContents();

            return $this->serializer->deserialize($responseData, RatingHttpDto::class, 'json');
        } catch (\Exception|GuzzleException $e) {
            return (new RatingHttpDto())
                ->setStatus($e->getCode())
                ->setMessage($e->getMessage());
        }
    }
}