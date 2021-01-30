<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Entity;

use App\Repository\EventRepository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 * @ORM\Table(name="`event`")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="text")
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="text")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="payload", type="text")
     */
    private $payload;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * Class Constructor.
     */
    public function __construct()
    {
        $this->uuid = (string) Uuid::uuid4();
        $this->createdAt = new DateTime('NOW', new DateTimeZone('UTC'));
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set type.
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set UUID.
     */
    public function setUUID(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get UUID.
     */
    public function getUUID(): string
    {
        return $this->uuid;
    }

    /**
     * Set payload.
     */
    public function setPayload(array $payload): self
    {
        $this->payload = json_encode($payload);

        return $this;
    }

    /**
     * Get payload.
     */
    public function getPayload(): array
    {
        return json_decode($this->payload, true);
    }

    /**
     * Set createdAt.
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Create a new instance from an Array.
     */
    public static function fromArray(array $data): self
    {
        $data['createdAt'] = (isset($data['createdAt'])) ?: new DateTime('NOW', new DateTimeZone('UTC'));
        $data['uuid'] = (isset($data['uuid'])) ?: (string) Uuid::uuid4();

        return (new self())
            ->setType($data['type'])
            ->setUUID($data['uuid'])
            ->setPayload($data['payload'])
            ->setCreatedAt($data['createdAt']);
    }
}
