<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

final class GateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Gate::define('update-asset', function(User $user, Asset $asset) {
            if ($user->id !== $asset->user_id) {
                return false;
            }

            if ($asset->relationLoaded('user.wallet')) {
                return $asset->user->wallet !== null;
            }

            return $asset->user()->whereHas('wallet')->exists();
        });

        Gate::define('delete-asset', function(User $user, Asset $asset) {
            if ($user->id !== $asset->user_id) {
                return false;
            }

            if ($asset->relationLoaded('user.wallet')) {
                return $asset->user->wallet !== null;
            }

            return $asset->user()->whereHas('wallet')->exists();
        });
    }
}
