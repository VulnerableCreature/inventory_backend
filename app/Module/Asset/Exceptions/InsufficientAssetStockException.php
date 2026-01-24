<?php

declare(strict_types=1);

namespace App\Module\Asset\Exceptions;

use App\Shared\AppException;

final class InsufficientAssetStockException extends AppException
{
    public function __construct(
        private readonly int $requestedQuantity,
        private readonly int $availableQuantity,
    )
    {
        parent::__construct(
            "There are $this->availableQuantity assets in the warehouse, the requested quantity is $this->requestedQuantity",
            422
        );
    }
}
