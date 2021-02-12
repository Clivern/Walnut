<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use App\Event\AuditAction;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * AuditActionSubscriber Class.
 */
class AuditActionSubscriber implements EventSubscriberInterface
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
    public function onAuditAction(AuditAction $action)
    {
        $this->logger->info(sprintf(
            'Event with type %s created with ID %d, UUID %s',
            $action->getEvent()->getType(),
            $action->getEvent()->getId(),
            $action->getEvent()->getUUID()
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
            AuditAction::NAME => 'onAuditAction',
        ];
    }
}
