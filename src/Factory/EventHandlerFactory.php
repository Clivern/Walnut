<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Factory;

use App\Handler\MessageFailedEvent;
use App\Handler\MessageHandledEvent;
use App\Handler\MessageReceivedEvent;
use App\Handler\MessageSendFailureEvent;
use App\Handler\MessageSentEvent;
use Clivern\Chunk\Core\EventHandler;

/**
 * EventHandlerFactory Class.
 */
class EventHandlerFactory
{
    /**
     * Create Event Handler.
     */
    public static function createEventHandler(): EventHandler
    {
        $eventHandler = new EventHandler();

        $eventHandler->addEvent(new MessageReceivedEvent())
            ->addEvent(new MessageFailedEvent())
            ->addEvent(new MessageHandledEvent())
            ->addEvent(new MessageSentEvent())
            ->addEvent(new MessageSendFailureEvent());

        return $eventHandler;
    }
}
