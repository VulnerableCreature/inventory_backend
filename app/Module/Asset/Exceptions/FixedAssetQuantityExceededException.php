<?php

declare(strict_types=1);

namespace App\Module\Asset\Exceptions;

use App\Shared\AppException;

final class FixedAssetQuantityExceededException extends AppException
{
    public function __construct(
        private readonly int $quantity,
    )
    {
        parent::__construct(
            "Fixed asset quantity cannot exceed 1. Got: $this->quantity",
            422
        );
    }
}
