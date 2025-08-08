<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GpsDataController;



Route::prefix('gps-data')->group(function () {
    Route::get('latest', [GpsDataController::class, 'latestData']);
    Route::get('filter', [GpsDataController::class, 'filterByDate']);
    Route::get('device/{deviceId}', [GpsDataController::class, 'byDeviceId']);
});

Route::apiResource('gps-data', GpsDataController::class)->except([
    'update',
    'destroy'
]);
