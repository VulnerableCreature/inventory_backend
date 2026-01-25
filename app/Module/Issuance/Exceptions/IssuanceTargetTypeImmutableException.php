<?php

declare(strict_types=1);

namespace App\Module\Issuance\Exceptions;

use App\Shared\AppException;

final class IssuanceTargetTypeImmutableException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            "This issue does not support installation in another device. It is not possible to add the device to the issue issued to the employee",
            422
        );
    }
}
