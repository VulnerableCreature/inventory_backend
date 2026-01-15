<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use App\Shared\AppException;
use Override;

final class NegativeAmountException extends AppException
{
    public function __construct(
        private readonly float $amount,
    )
    {
        parent::__construct(
            "Amount cannot be negative. Got: $this->amount",
            422
        );
    }
}
