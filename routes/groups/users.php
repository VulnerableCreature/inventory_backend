<?php

use App\Http\Controllers\Main\User\UserController;
use App\Http\Controllers\Main\User\UserWalletController;

Route::group(['namespace' => 'User', 'prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::delete('/{id}', [UserController::class, 'delete']);

    Route::group(['namespace' => 'Wallet', 'prefix' => 'wallets'], function () {
        Route::post('/{id}', [UserWalletController::class, 'attach']);
    });
});
