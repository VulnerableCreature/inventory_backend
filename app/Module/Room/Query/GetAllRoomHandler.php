<?php

declare(strict_types=1);

namespace App\Module\Room\Query;

use App\Models\Room;
use Illuminate\Support\Collection;

final readonly class GetAllRoomHandler
{
    public function handle(): Collection
    {
        return Room::query()
            ->orderBy('number')
            ->get();
    }
}
