<?php

use App\Http\Controllers\Main\Room\RoomController;

Route::group(['namespace' => 'Room', 'prefix' => 'rooms'], function() {
    Route::get('/', [RoomController::class, 'index']);
    Route::get('/{id}', [RoomController::class, 'show']);
    Route::post('/', [RoomController::class, 'store']);
    Route::patch('/{id}', [RoomController::class, 'update']);
    Route::delete('/{id}', [RoomController::class, 'destroy']);
});
