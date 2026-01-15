<?php

declare(strict_types=1);

namespace App\Module\Asset\Exceptions;

use App\Shared\AppException;
use Override;

final class DuplicateInventoryNumberException extends AppException
{
    public function __construct(
        private readonly string $inventoryNumber,
    )
    {
        parent::__construct(
            "Asset with inventory number $this->inventoryNumber already exists",
            400
        );
    }
}
