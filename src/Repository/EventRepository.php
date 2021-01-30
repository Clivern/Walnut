<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Repository;

use App\Entity\Event;
use App\Event\EventCreated;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Event Repository.
 */
class EventRepository extends ServiceEntityRepository
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /**
     * Class constructor.
     */
    public function __construct(
        ManagerRegistry $registry,
        EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct($registry, Event::class);
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Store a new Event.
     */
    public function storeOne(Event $event): ?Event
    {
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();

        $eventCreated = new EventCreated($event);
        $this->eventDispatcher->dispatch($eventCreated, EventCreated::NAME);

        return $event;
    }
}
