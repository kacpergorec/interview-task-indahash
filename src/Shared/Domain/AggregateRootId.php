<?php
declare (strict_types=1);

namespace App\Shared\Domain;

use Symfony\Component\Uid\Uuid;

abstract class AggregateRootId implements \JsonSerializable
{
    protected Uuid $id;

    public function __construct(Uuid $uuid)
    {
        $this->id = $uuid;
    }

    public function toUuid(): Uuid
    {
        return $this->id;
    }

    public static function fromString(string $uuid): static
    {
        return new static(Uuid::fromString($uuid));
    }

    public function jsonSerialize(): string
    {
        return static::toUuid()->toString();
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }

    public static function new(): static
    {
        return new static(Uuid::v7());
    }
}
