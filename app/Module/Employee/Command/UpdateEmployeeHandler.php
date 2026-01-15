<?php

declare(strict_types=1);

namespace App\Module\Employee\Command;

use App\Application\Employee\Command\UpdateEmployeeCommand;
use App\Models\Employee;

final readonly class UpdateEmployeeHandler
{
    public function handle(UpdateEmployeeCommand $command): Employee
    {
        $employee = Employee::query()->findOrFail($command->id);

        $employee->update([
            'surname' => $command->surname,
            'name' => $command->name,
            'middleName' => $command->middleName,
        ]);

        return $employee->fresh();
    }
}
