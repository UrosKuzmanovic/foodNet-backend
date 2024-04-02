<?php

namespace App\Controller;

use App\Entity\Dto\AnalyticsDto;
use App\EventListener\Events\SendAnalyticsEvent;
use App\Service\Microservices\AnalyticsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/api/foodnet/analytics")
 */
class AnalyticsController extends AbstractController
{

    private AnalyticsService $analyticsService;
    private SerializerInterface $serializer;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        AnalyticsService $analyticsService,
        SerializerInterface $serializer,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->analyticsService = $analyticsService;
        $this->serializer = $serializer;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/send", name="send_analytics")
     */
    public function send(Request $request): JsonResponse
    {
        /** @var AnalyticsDto $analytics */
        $analytics = $this->serializer->deserialize($request->getContent(), AnalyticsDto::class, 'json');

        $this->dispatcher->dispatch(new SendAnalyticsEvent($analytics), SendAnalyticsEvent::class);

        return $this->json([
            'status' => Response::HTTP_OK,
            'message' => 'Analytics sent',
        ]);
    }

    /**
     * @Route("/get-time", name="get_time_analytics")
     */
    public function getTime(Request $request): JsonResponse
    {
        /** @var AnalyticsDto $analytics */
        $analytics = $this->serializer->deserialize($request->getContent(), AnalyticsDto::class, 'json');

        $analyticsHttpDto = $this->analyticsService->post($analytics, 'test/get-time');

        return $this->json([
            'status' => $analyticsHttpDto->getStatus(),
            'message' => $analyticsHttpDto->getMessage(),
            'data' => $analyticsHttpDto->getData(),
        ]);
    }
}
