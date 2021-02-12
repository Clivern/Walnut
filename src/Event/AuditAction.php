<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Event;

use App\Entity\Event;
use Symfony\Contracts\EventDispatcher\Event as SymfonyEvent;

/**
 * AuditAction Class.
 */
class AuditAction extends SymfonyEvent
{
    public const NAME = 'audit.action';

    /** @var Event */
    protected $event;

    /**
     * Class Constructor.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get Event Instance.
     */
    public function getEvent(): Event
    {
        return $this->event;
    }
}
