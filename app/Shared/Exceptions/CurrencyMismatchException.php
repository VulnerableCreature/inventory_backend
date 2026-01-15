<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use App\Shared\AppException;

final class CurrencyMismatchException extends AppException
{
    public function __construct(
        private readonly string $currency,
        private readonly string $secondCurrency,
    )
    {
        parent::__construct(
            "Cannot with different currencies: $this->currency and $this->secondCurrency",
            422
        );
    }
}
