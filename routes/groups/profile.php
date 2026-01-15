<?php

use App\Http\Controllers\Main\User\ProfileController;

Route::group(['namespace' => 'Profile', 'prefix' => 'profile'], function () {
    Route::get('/', [ProfileController::class, 'index']);
    Route::patch('/', [ProfileController::class, 'update']);
});
