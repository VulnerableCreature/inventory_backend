<?php

namespace App\CQRS;

use Ramsey\Uuid\UuidInterface;

interface OperationInterface
{
    public function getUuid(): UuidInterface;
}
