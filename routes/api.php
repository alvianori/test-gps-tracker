<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GpsDataController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;



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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users', [UserController::class, 'store'])->middleware('role:super_admin');
    Route::post('/logout', [AuthController::class, 'logout']);

    // contoh: cek profile user
    Route::get('/check', function (Request $request) {
        $user = $request->user();

        return response()->json([
            'id'          => $user->id,
            'name'        => $user->name,
            'email'       => $user->email,
            'roles'       => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    });
});