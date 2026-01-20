<?php

namespace App\Models;

use App\Module\Room\Enums\RoomTypeEnum;
use App\Shared\Entity\Occupant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

/**
 * @property int                                   $id
 * @property string                                $name
 * @property int                                   $number
 * @property RoomTypeEnum                          $type
 * @property string                                $building
 * @property int                                   $floor
 *
 * @property Collection<int, User>|MorphToMany     $users
 * @property Collection<int, Employee>|MorphToMany $employees
 * @property Collection<int, Occupant>             $occupants
 */
final class Room extends Model
{
    protected $table = 'rooms';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'number',
        'type',
        'building',
        'floor'
    ];

    protected function casts(): array
    {
        return [
            'type' => RoomTypeEnum::class,
        ];
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'occupant', 'room_occupants');
    }

    public function employees(): MorphToMany
    {
        return $this->morphedByMany(Employee::class, 'occupant', 'room_occupants');
    }

    public function getOccupantsAttribute(): Collection
    {
        $users = $this->users->map(fn(User $user) => Occupant::fromUser($user));
        $employees = $this->employees->map(fn(Employee $employee) => Occupant::fromEmployee($employee));

        return $users->merge($employees)->sortBy('shortName')->values();
    }
}
