<?php

declare(strict_types = 1);

namespace App\Shared\Domain\Bus\Event;

use DateTimeImmutable;
use App\Shared\Domain\Utils;
use App\Shared\Domain\ValueObject\Uuid;

abstract class DomainEvent
{
    private $aggregateId;
    private $eventId;
    private $occurredOn;

    public function __construct(string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->aggregateId = $aggregateId;
        $this->eventId     = $eventId ?: Uuid::random()->value();
        $this->occurredOn  = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
