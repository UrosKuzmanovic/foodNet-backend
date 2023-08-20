<?php

namespace App\Controller;

use App\Entity\Dto\AnalyticsDto;
use App\EventListener\Events\SendAnalyticsEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/api/foodnet/analytics")
 */
class AnalyticsController extends AbstractController
{

    private SerializerInterface $serializer;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        SerializerInterface $serializer,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->serializer = $serializer;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/send", name="app_analytics")
     */
    public function index(Request $request): JsonResponse
    {
        /** @var AnalyticsDto $analytics */
        $analytics = $this->serializer->deserialize($request->getContent(), AnalyticsDto::class, 'json');

        $this->dispatcher->dispatch(new SendAnalyticsEvent($analytics), SendAnalyticsEvent::class);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AnalyticsController.php',
        ]);
    }
}
