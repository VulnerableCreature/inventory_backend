<?php

namespace App\Module\Room\Traits;

use App\Models\Room;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

/**
 * @property Collection<int, Room>|MorphToMany $rooms
 */
trait MorphToManyRoomsTrait
{
    public function rooms(): MorphToMany
    {
        return $this->morphToMany(Room::class, 'occupant', 'room_occupants');
    }
}
