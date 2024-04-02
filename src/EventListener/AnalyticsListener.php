<?php

namespace App\EventListener;

use App\Entity\Dto\AnalyticsDto;
use App\Entity\Dto\AnalyticsHttpDto;
use App\EventListener\Events\SendAnalyticsEvent;
use App\Service\Microservices\AnalyticsService;
use App\Service\Microservices\AuthenticatorService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AnalyticsListener implements EventSubscriberInterface
{

    private AuthenticatorService $authenticatorService;
    private AnalyticsService $analyticsService;

    public function __construct(
        AuthenticatorService $authenticatorService,
        AnalyticsService     $analyticsService
    )
    {
        $this->authenticatorService = $authenticatorService;
        $this->analyticsService = $analyticsService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SendAnalyticsEvent::class => 'onSendAnalytics',
        ];
    }

    /**
     * @param SendAnalyticsEvent $event
     * @return AnalyticsHttpDto
     */
    public function onSendAnalytics(SendAnalyticsEvent $event): AnalyticsHttpDto
    {
        $author = $this->authenticatorService->getAuthor();

        $analytics = $event->getAnalyticsDto()
            ->setUserId($author ? $author->getId() : null)
            ->setTime(new \DateTime());

        return $this->analyticsService->post($analytics);
    }

}