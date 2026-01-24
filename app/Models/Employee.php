<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property int                               $id
 * @property string                            $surname
 * @property string                            $name
 * @property string                            $middleName
 * @property Carbon                            $created_at
 * @property Carbon                            $updated_at
 *
 * @property string                            $shortName
 *
 * @property Collection<int, Room>|MorphToMany $rooms
 */
final class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'surname',
        'name',
        'middleName',
    ];

    public function getShortNameAttribute(): string
    {
        $name = Str::take(Str::ucfirst($this->name), 1);
        $middleName = Str::take(Str::ucfirst($this->middleName), 1);
        return "$this->surname $name.$middleName";
    }

    public function rooms(): MorphToMany
    {
        return $this->morphToMany(Room::class, 'occupant', 'room_occupants');
    }
}
