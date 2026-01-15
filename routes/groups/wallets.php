<?php

use App\Http\Controllers\Main\Wallet\WalletController;

Route::group(['namespace' => 'Asset', 'prefix' => 'wallets'], function() {
    Route::get('/{id}', [WalletController::class, 'show']);
});
