<?php

declare(strict_types=1);

namespace App\Application\User\Query;

use App\CQRS\QueryInterface;

final readonly class GetUserProfileQuery implements QueryInterface
{
    public function __construct()
    {
    }
}
