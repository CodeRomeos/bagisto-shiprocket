<?php

use Illuminate\Support\Facades\Route;
use CodeRomeos\BagistoShiprocket\Http\Controllers\Admin\BagistoShiprocketController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/bagistoshiprocket'], function () {
    Route::controller(BagistoShiprocketController::class)->group(function () {
        Route::get('', 'index')->name('admin.bagistoshiprocket.index');
    });
});