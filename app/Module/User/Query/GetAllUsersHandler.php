<?php

declare(strict_types=1);

namespace App\Module\User\Query;

use App\Application\User\Query\GetAllUsersQuery;
use App\Models\User;
use App\Module\User\UserFilter;
use Illuminate\Support\Collection;

final readonly class GetAllUsersHandler
{
    public function __construct()
    {
    }

    public function handle(GetAllUsersQuery $usersQuery): Collection
    {
        $query = User::query()
            ->with(['profile', 'wallet'])
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.*');

        if (!empty($usersQuery->filters)) {
            $filter = new UserFilter($usersQuery->filters);
            $filter->apply($query);
        }

        $query->orderByRaw('profiles.user_id IS NOT NULL DESC')
            ->orderBy('profiles.surname')
            ->orderBy('users.login');

        return $query->get();
    }
}
