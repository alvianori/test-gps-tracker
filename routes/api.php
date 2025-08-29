<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GpsTrackController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// GPS Track routes (for IoT devices without middleware)
Route::prefix('gps-tracks')->controller(GpsTrackController::class)->group(function () {
    Route::post('/', 'store');
    Route::post('/bulk', 'storeBulk');
    Route::get('/device/{deviceCode}', 'byDeviceCode');
    Route::get('/latest', 'latestData');
    Route::get('/filter', 'filterByDate');
});