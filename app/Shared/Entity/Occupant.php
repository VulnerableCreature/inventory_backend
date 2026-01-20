<?php

declare(strict_types=1);

namespace App\Shared\Entity;

use App\Models\Employee;
use App\Models\User;

final readonly class Occupant
{
    public function __construct(
        public int    $id,
        public string $type,
        public string $shortName,
    )
    {
    }

    public static function fromUser(User $user): self
    {
        return new self(
            id: $user->id,
            type: "user",
            shortName: $user->shortName
        );
    }

    public static function fromEmployee(Employee $employee): self
    {
        return new self(
            id: $employee->id,
            type: "employee",
            shortName: $employee->shortName
        );
    }
}
