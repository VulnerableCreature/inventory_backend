<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Module\Room\Traits\MorphToManyRoomsTrait;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int                            $id
 * @property string                         $login
 * @property string                         $password
 * @property string                         $remember_token
 * @property Carbon                         $created_at
 * @property Carbon                         $updated_at
 *
 * @property string                         $shortName
 *
 * @property Profile|HasOne                 $profile
 * @property Wallet|HasOne                  $wallet
 * @property Collection<int, Asset>|HasMany $assets
 */
final class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens;
    use MorphToManyRoomsTrait;

    protected $table = 'users';

    protected $fillable = [
        'login',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'user_id', 'id');
    }

    public function getShortNameAttribute(): string
    {
        if ($this->profile) {
            $name = Str::take(Str::ucfirst($this->profile->name), 1);
            $middleName = Str::take(Str::ucfirst($this->profile->middleName), 1);
            return "{$this->profile->surname} $name.$middleName";
        }

        return $this->login;
    }
}
