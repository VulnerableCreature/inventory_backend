<?php

declare(strict_types=1);

namespace App\Module\Issuance\Exceptions;

use App\Shared\AppException;

final class RoomNotAssignedToIssuableException extends AppException
{
    public function __construct(
        public int $roomId,
    )
    {
        parent::__construct(
            "The employee is not assigned to the specified room. Got: $this->roomId",
            422
        );
    }
}
