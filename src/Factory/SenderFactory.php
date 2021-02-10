<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Factory;

use Clivern\Chunk\Core\Broker\RabbitMQ;
use Clivern\Chunk\Core\EventHandler;
use Clivern\Chunk\Core\Sender;
use Exception;

/**
 * SenderFactory Class.
 */
class SenderFactory
{
    /**
     * Create Sender.
     */
    public static function createSender(EventHandler $eventHandler): Sender
    {
        $data = SenderFactory::getConnection();

        $configs = [
            'consumer' => [
                'no_ack' => true,
            ],

            'vhost' => '/',

            'queue' => [
                'name' => $_ENV['RABBITMQ_QUEUE'],
            ],

            'routing' => [
                'key' => [$_ENV['RABBITMQ_QUEUE']],
            ],
        ];

        $broker = new RabbitMQ(
            $data['hostname'],
            $data['port'],
            $data['username'],
            $data['password'],
            $configs
        );

        return new Sender($broker, $eventHandler);
    }

    /**
     * Get Connection.
     *
     * @return array
     */
    public static function getConnection()
    {
        if (empty($_ENV['RABBITMQ_SERVER']) || empty($_ENV['RABBITMQ_QUEUE'])) {
            throw new Exception(
                "Missing environment variables RABBITMQ_SERVER or RABBITMQ_QUEUE"
            );
        }

        $connectionString = explode("@", $_ENV['RABBITMQ_SERVER']);
        $logins           = explode(":", $connectionString[0]);
        $server           = explode(":", $connectionString[1]);

        return [
            "username" => $logins[0],
            "password" => $logins[1],
            "hostname" => $server[0],
            "port"     => (int) $server[1],
        ];
    }
}
