<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Handler;

use Clivern\Chunk\Contract\EventInterface;
use Clivern\Chunk\Contract\MessageInterface;

/**
 * MessageSentEvent Class.
 */
class MessageSentEvent implements EventInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return EventInterface::ON_MESSAGE_SENT_EVENT;
    }

    /**
     * {@inheritdoc}
     */
    public function invoke(MessageInterface $message, $exception = null)
    {
        var_dump(sprintf('Message Sent Event: %s', (string) $message));
    }
}
