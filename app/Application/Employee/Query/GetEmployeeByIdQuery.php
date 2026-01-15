<?php

declare(strict_types=1);

namespace App\Application\Employee\Query;

use App\CQRS\QueryInterface;

final readonly class GetEmployeeByIdQuery implements QueryInterface
{
    public function __construct(public int $id)
    {
    }
}
