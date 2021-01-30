<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use OpenApi\Annotations as OA;
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
        EventRepository $eventRepository
    ) {
        $this->eventRepository = $eventRepository;
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
        $event = Event::fromArray([
            'type' => 'healthCheck',
            'payload' => ['key' => 'value'],
        ]);

        $this->eventRepository->storeOne($event);

        return $this->json([
            'status' => 'ok',
        ]);
    }
}
