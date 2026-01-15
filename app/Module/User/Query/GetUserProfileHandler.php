<?php

declare(strict_types=1);

namespace App\Module\User\Query;

use App\Models\Profile;

final class GetUserProfileHandler
{
    public function handle(): ?Profile
    {
        return Profile::query()->findOrFail(auth()->id());
    }
}
