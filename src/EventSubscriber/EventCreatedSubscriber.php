<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use App\Event\EventCreated;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * EventCreatedSubscriber Class.
 */
class EventCreatedSubscriber implements EventSubscriberInterface
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Event Created Handler.
     */
    public function onEventCreated(EventCreated $event)
    {
        $this->logger->info(sprintf(
            'Event created with ID %d, UUID %s',
            $event->getEvent()->getId(),
            $event->getEvent()->getUUID()
        ));
    }

    /**
     * Get Subscribed Events.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            EventCreated::NAME => 'onEventCreated',
        ];
    }
}
