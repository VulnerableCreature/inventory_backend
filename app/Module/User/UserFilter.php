<?php

declare(strict_types=1);

namespace App\Module\User;

use App\Shared\Filter;
use Illuminate\Database\Eloquent\Builder;

final readonly class UserFilter extends Filter
{
    protected function login(Builder $query, mixed $value): void
    {
        $query->where('login', '=', $value);
    }

    protected function surname(Builder $query, mixed $value): void
    {
        $query->where('profiles.surname', '=', $value);
    }
}
