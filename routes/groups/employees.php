<?php

use App\Http\Controllers\Main\Employee\EmployeeController;

Route::group(['namespace' => 'Employee', 'prefix' => 'employees'], function() {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::get('/{id}', [EmployeeController::class, 'show']);
    Route::post('/', [EmployeeController::class, 'store']);
    Route::patch('/{id}', [EmployeeController::class, 'update']);
    Route::delete('/{id}', [EmployeeController::class, 'destroy']);
});
