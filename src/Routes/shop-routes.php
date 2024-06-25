<?php

use Illuminate\Support\Facades\Route;
use CodeRomeos\BagistoShiprocket\Http\Controllers\Shop\BagistoShiprocketController;

// Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'bagistoshiprocket'], function () {
//     Route::get('', [BagistoShiprocketController::class, 'index'])->name('shop.bagistoshiprocket.index');
// });

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'shiprocket'], function () {
    Route::get('tracking', [BagistoShiprocketController::class, 'tracking'])->name('shop.bagistoshiprocket.tracking');
    Route::get('estimated-delivery', [BagistoShiprocketController::class, 'getEstimatedDelivery'])->name('shop.bagistoshiprocket.tracking');
    Route::get('pincode-availability', [BagistoShiprocketController::class, 'checkPincodeAvailability'])->name('shop.bagistoshiprocket.pincode_availability');
});
