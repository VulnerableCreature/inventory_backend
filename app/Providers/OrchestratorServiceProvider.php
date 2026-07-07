<?php

namespace App\Providers;

use App\Module\Issuance\Orchestrators\CreateIssuanceOrchestrator;
use App\Module\Issuance\Orchestrators\UpdateIssuanceOrchestrator;
use Illuminate\Support\ServiceProvider;

final class OrchestratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CreateIssuanceOrchestrator::class);
        $this->app->singleton(UpdateIssuanceOrchestrator::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
