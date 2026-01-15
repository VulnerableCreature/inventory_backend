<?php

use App\Http\Controllers\Authorization\AuthorizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::post('/login', [AuthorizationController::class, 'store'])->middleware(['guest', 'throttle:login']);

    Route::group(['namespace' => 'Authorization', 'middleware' => ['auth:sanctum', 'throttle:api']], function() {
        Route::delete('/logout', [AuthorizationController::class, 'destroy']);

        require __DIR__ . '/groups/profile.php';
        require __DIR__ . '/groups/users.php';
        require __DIR__ . '/groups/assets.php';
        require __DIR__ . '/groups/wallets.php';
        require __DIR__ . '/groups/employees.php';
    });
});
