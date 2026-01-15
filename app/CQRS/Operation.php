<?php

declare(strict_types=1);

namespace App\CQRS;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class Operation implements OperationInterface
{
    private function __construct(
        private UuidInterface $uuid,
    )
    {
    }

    public static function create(): OperationInterface
    {
        return new self(
            Uuid::uuid7()
        );
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}
