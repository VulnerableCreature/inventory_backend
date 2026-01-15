<?php

declare(strict_types=1);

namespace App\Application\User\Query;

use App\CQRS\QueryInterface;

final readonly class GetAllUsersQuery implements QueryInterface
{
    public function __construct(public array $filters = [])
    {
    }
}
