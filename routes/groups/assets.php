<?php

use App\Http\Controllers\Main\Asset\AssetController;

Route::group(['namespace' => 'Asset', 'prefix' => 'assets'], function () {
    Route::get('/', [AssetController::class, 'index']);
    Route::get('/{id}', [AssetController::class, 'show']);
    Route::post('/', [AssetController::class, 'store']);
    Route::patch('/{id}', [AssetController::class, 'update']);
    Route::delete('/{id}', [AssetController::class, 'destroy']);
});
