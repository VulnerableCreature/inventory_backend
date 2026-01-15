<?php

declare(strict_types=1);

namespace App\Module\User\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User|BelongsTo $user
 */
trait BelongsToUserTrait
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
