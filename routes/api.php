<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GpsDataController;



Route::prefix('gps-data')->controller(GpsDataController::class)->group(function () {
    Route::get('latest', 'latestData');
    Route::get('filter', 'filterByDate');
    Route::get('device/{deviceId}', 'byDeviceId');
    Route::post('bulk', 'storeBulk');
});


Route::apiResource('gps-data', GpsDataController::class)->except([
    'update',
    'destroy'
]);
