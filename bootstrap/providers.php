<?php

return [
    App\CQRS\CQRSServiceProvider::class,
    App\Providers\AppServiceProvider::class,
    App\Providers\GateServiceProvider::class,
    App\Providers\OrchestratorServiceProvider::class,
    App\Providers\RateLimiterServiceProvider::class,
    App\Providers\RelationEnforceMorphMapServiceProvider::class,
];
