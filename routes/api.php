<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GpsDataController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/check', [AuthController::class, 'check']);
});


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
