<?php

declare(strict_types=1);

/*
 * This file is part of the Clivern/Walnut project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Validator\GenericValidator;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * CorrelationIdSubscriber Class.
 */
class CorrelationIdSubscriber
{
    /** @var RequestStack */
    private $requestStack;

    /** @var GenericValidator */
    private $validator;

    /**
     * Class Constructor.
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->validator    = new GenericValidator();
    }

    /**
     * Appends CorrelationId to log record.
     *
     * @return array
     */
    public function __invoke(array $record)
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request && !empty($request->headers->get('X-Correlation-ID'))
            && $this->validator->validate($request->headers->get('X-Correlation-ID'))) {
            $record['extra']['CorrelationId'] = $request->headers->get('X-Correlation-ID');

            return $record;
        }

        $record['extra']['CorrelationId'] = Uuid::uuid4()->toString();

        return $record;
    }
}
