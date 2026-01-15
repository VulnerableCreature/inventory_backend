<?php

declare(strict_types=1);

namespace App\Module\Employee\Command;

use App\Application\Employee\Command\CreateEmployeeCommand;
use App\Models\Employee;

final readonly class CreateEmployeeHandler
{
    public function handle(CreateEmployeeCommand $command): Employee
    {
        return Employee::query()->create([
            'surname' => $command->surname,
            'name' => $command->name,
            'middleName' => $command->middleName,
        ]);
    }
}
