<?php

namespace App\Controller;

use App\Manager\AuthorManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/foodnet/author")
 */
class AuthorController extends AbstractController
{

    /** @var AuthorManager */
    private AuthorManager $manager;

    public function __construct(AuthorManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/all", name="get_all_authors")
     */
    public function getAll(): JsonResponse
    {
        $authenticatorUrl = "http://authenticator:9000/api/authenticator/user"; // Replace with the actual URL and port of the authenticator service

        $ch = curl_init($authenticatorUrl);

// Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        try {
            $response = curl_exec($ch);

            // Check for cURL errors
            if (curl_errno($ch)) {
                throw new Exception('cURL Error: ' . curl_error($ch));
            }

            // Check for HTTP error status codes
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode >= 400) {
                throw new Exception('HTTP Error: ' . $httpCode);
            }

            // Process the response data received from the authenticator service
            $data = json_decode($response, true);
            // Process the data received from the authenticator service
            echo "Authentication response: " . print_r($data, true);
        } catch (Exception $e) {
            echo "Error connecting to the authenticator service: " . $e->getMessage();
        }

// Close cURL resource
        curl_close($ch);


        return $this->json($this->manager->findAll());
    }
}
