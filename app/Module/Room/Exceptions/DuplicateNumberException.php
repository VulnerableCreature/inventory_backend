<?php

declare(strict_types=1);

namespace App\Module\Room\Exceptions;

use App\Shared\AppException;

final class DuplicateNumberException extends AppException
{
    public function __construct(
        private readonly int $number,
    )
    {
        parent::__construct(
            "Room with number $this->number already exists",
            400
        );
    }
}
