<?php

declare(strict_types=1);

namespace App\Module\Employee\Command;

use App\Application\Employee\Command\DeleteEmployeeCommand;
use App\Models\Employee;

final readonly class DeleteEmployeeHandler
{
    public function handle(DeleteEmployeeCommand $command): void
    {
        $employee = Employee::query()->findOrFail($command->id);
        $employee->delete();
    }
}
