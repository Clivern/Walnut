<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Factory;

use App\Handler\ProcessOrderMessageHandler;
use Clivern\Chunk\Core\Mapper;

/**
 * EventMapperFactory Class.
 */
class EventMapperFactory
{
    /**
     * Create Event Mapper.
     */
    public static function createEventMapper(): Mapper
    {
        $mapper = new Mapper();
        $mapper->addHandler(new ProcessOrderMessageHandler());

        return $mapper;
    }
}
