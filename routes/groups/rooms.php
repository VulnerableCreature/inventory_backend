<?php

use App\Http\Controllers\Main\Room\RoomController;
use App\Http\Controllers\Main\Room\RoomOccupantController;

Route::group(['namespace' => 'Room', 'prefix' => 'rooms'], function() {
    Route::get('/', [RoomController::class, 'index']);
    Route::get('/{id}', [RoomController::class, 'show']);
    Route::post('/', [RoomController::class, 'store']);
    Route::patch('/{id}', [RoomController::class, 'update']);
    Route::delete('/{id}', [RoomController::class, 'destroy']);

    Route::group(['namespace' => 'Occupant', 'prefix' => 'occupants'], function() {
        Route::post('/{id}', [RoomOccupantController::class, 'store']);
        Route::delete('/{id}', [RoomOccupantController::class, 'destroy']);
    });
});
