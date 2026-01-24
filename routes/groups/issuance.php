<?php

use App\Http\Controllers\Main\Issuance\IssuanceController;

Route::apiResources([
    'issuances' => IssuanceController::class,
], [
    'parameters' => [
        'issuances' => 'id',
    ],
]);
