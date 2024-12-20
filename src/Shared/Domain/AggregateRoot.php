<?php
declare (strict_types=1);

namespace App\Shared\Domain;

abstract class AggregateRoot implements \JsonSerializable
{
    /**
     * @var DomainEventInterface[] $domainEvents
     */
    protected array $domainEvents = [];

    final protected function raise(DomainEventInterface $event): self
    {
        $this->domainEvents[] = $event;

        return $this;
    }

    final public function pullEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    abstract public function toArray(): array;

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
