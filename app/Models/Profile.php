<?php

namespace App\Models;

use App\Module\User\Traits\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int            $user_id
 * @property string         $surname
 * @property string         $name
 * @property string         $middleName
 *
 * @property User|BelongsTo $user
 */
final class Profile extends Model
{
    use BelongsToUserTrait;

    protected $table = 'profiles';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'surname',
        'name',
        'middleName',
    ];

    protected $hidden = [
        'user_id',
    ];
}
