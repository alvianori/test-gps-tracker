<?php

use Illuminate\Support\Facades\Route;
use App\Models\GpsData;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fetch-gps', function () {
    $response = Http::get('https://test-gps.atlasdigitalize.com/api/gps-data/device/ESP004');

    if ($response->successful()) {
        $data = $response->json();

        // ambil 100 data terakhir (terbaru)
        $latest100 = array_slice($data, -100);

        foreach ($latest100 as $item) {
            GpsData::updateOrCreate(
                ['id' => $item['id']],
                [
                    'device_id' => $item['device_id'],
                    'latitude' => $item['latitude'],
                    'longitude' => $item['longitude'],
                    'speed' => $item['speed'],
                    'course' => $item['course'],
                    'direction' => $item['direction'],
                    'devices_timestamp' => $item['devices_timestamp'],
                ]
            );
        }
        return response()->json(['message' => '100 data GPS terbaru berhasil disimpan.']);
    }

    return response()->json(['message' => 'Gagal mengambil data.'], 500);
});