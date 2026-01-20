<?php

declare(strict_types=1);

namespace App\Module\User\Query;

use App\Application\User\Query\GetUserByIdQuery;
use App\Models\User;

final readonly class GetUserByIdHandler
{
    public function __construct()
    {
    }

    public function handle(GetUserByIdQuery $query): User
    {
        return User::query()->with(['profile', 'wallet', 'rooms'])->findOrFail($query->id);
    }
}
