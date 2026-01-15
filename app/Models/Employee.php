<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $surname
 * @property string $name
 * @property string $middleName
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'surname',
        'name',
        'middleName',
    ];
}
