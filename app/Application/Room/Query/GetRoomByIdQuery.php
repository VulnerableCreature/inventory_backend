<?php

declare(strict_types=1);

namespace App\Application\Room\Query;

use App\CQRS\QueryInterface;

final readonly class GetRoomByIdQuery implements QueryInterface
{
    public function __construct(public int $id)
    {
    }
}
