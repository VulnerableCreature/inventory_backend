<?php

namespace App\Models;

use App\Module\Room\Traits\MorphToManyRoomsTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int    $id
 * @property string $surname
 * @property string $name
 * @property string $middleName
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $shortName
 */
final class Employee extends Model
{
    use MorphToManyRoomsTrait;

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
}
