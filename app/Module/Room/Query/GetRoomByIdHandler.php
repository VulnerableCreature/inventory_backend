<?php

declare(strict_types=1);

namespace App\Module\Room\Query;

use App\Application\Room\Query\GetRoomByIdQuery;
use App\Models\Room;

final readonly class GetRoomByIdHandler
{
    public function handle(GetRoomByIdQuery $roomByIdQuery): Room
    {
        return Room::query()->findOrFail($roomByIdQuery->id);
    }
}
