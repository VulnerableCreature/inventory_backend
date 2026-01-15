<?php

declare(strict_types=1);

namespace App\Module\Employee\Query;

use App\Application\Employee\Query\GetEmployeeByIdQuery;
use App\Models\Employee;

final readonly class GetEmployeeByIdHandler
{
    public function handle(GetEmployeeByIdQuery $employeeByIdQuery): Employee
    {
        return Employee::query()->findOrFail($employeeByIdQuery->id);
    }
}
