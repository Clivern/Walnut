<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Handler;

use Clivern\Chunk\Contract\MessageHandlerInterface;
use Clivern\Chunk\Contract\MessageInterface;

/**
 * ProcessOrderMessageHandler Class.
 */
class ProcessOrderMessageHandler implements MessageHandlerInterface
{
    /**
     * Invoke Handler.
     */
    public function invoke(MessageInterface $message): MessageHandlerInterface
    {
        var_dump(sprintf('Process Message: %s', (string) $message));

        return $this;
    }

    /**
     * onSuccess Event.
     */
    public function onSuccess()
    {
        var_dump('Operation Succeeded');
    }

    /**
     * onFailure Event.
     */
    public function onFailure()
    {
        var_dump('Operation Failed');
    }

    /**
     * Handler Type.
     */
    public function getType(): string
    {
        return 'serviceA.processOrder';
    }
}
