<?php

declare(strict_types=1);

namespace App\Module\Asset\Exceptions;

use App\Shared\AppException;

final class InvalidQuantityException extends AppException
{
    public function __construct(
        private readonly int $quantity,
    )
    {
        parent::__construct(
            "Quantity must be greater than zero. Got: $this->quantity",
            422
        );
    }
}
