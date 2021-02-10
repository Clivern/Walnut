<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Clivern\Chunk\Core\Message;
use Clivern\Chunk\Core\Sender;
use OpenApi\Annotations as OA;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Health Controller.
 */
class HealthController extends AbstractController
{
    /** @var EventRepository */
    private $eventRepository;

    private $sender;

    /**
     * @OA\Info(
     *   title="Walnut API",
     *   version="0.1.0",
     *   @OA\Contact(
     *     email="hello@clivern.com"
     *   )
     * )
     */
    public function __construct(
        EventRepository $eventRepository,
        Sender $sender
    ) {
        $this->eventRepository = $eventRepository;
        $this->sender          = $sender;
    }

    /**
     * @Route("/", name="health")
     *
     * @OA\Schema(
     *   schema="Health",
     *   @OA\Property(property="status", type="string")
     * )
     *
     * @OA\Get(
     *     path="/",
     *     operationId="getHealth",
     *     @OA\Response(
     *       response="200",
     *       description="Application is up",
     *       @OA\JsonContent(ref="#/components/schemas/Health")
     *     ),
     *     @OA\Response(response="500", description="Application is down")
     * )
     */
    public function index(): Response
    {
        $this->sender->connect();

        $message = new Message();
        $message->setId(Uuid::uuid4()->toString())
            ->setPayload('something')
            ->setHandlerType('serviceA.processOrder');

        $this->sender->send($message);
        $this->sender->disconnect();

        $event = Event::fromArray([
            'type'    => 'healthCheck',
            'payload' => ['key' => 'value'],
        ]);

        $this->eventRepository->storeOne($event);

        return $this->json([
            'status' => 'ok',
        ]);
    }
}
