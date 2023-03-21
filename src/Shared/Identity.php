<?php

declare(strict_types=1);

namespace App\Shared;

use Symfony\Component\Uid\Uuid;

abstract class Identity
{
    public function __construct(protected readonly string $id)
    {
    }

    public static function generate(): static
    {
        return new static(Uuid::v4()->toRfc4122());
    }

    public static function fromIdentity(Identity $identity): static
    {
        return new static($identity->id());
    }

    public function id(): string
    {
        return $this->id;
    }

    public function equals(Identity $identity): bool
    {
        return $this->id() === $identity->id()
            && static::class === $identity::class;
    }

    public function __toString(): string
    {
        return $this->id();
    }
}
