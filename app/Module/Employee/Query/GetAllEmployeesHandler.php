<?php

declare(strict_types=1);

namespace App\Module\Employee\Query;

use App\Models\Employee;
use Illuminate\Support\Collection;

final readonly class GetAllEmployeesHandler
{
    public function handle(): Collection
    {
        return Employee::query()
            ->orderBy('surname')
            ->get();
    }
}
