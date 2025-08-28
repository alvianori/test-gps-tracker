<?php

namespace Database\Seeders;

use App\Models\GpsTrack;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GpsTrackSeeder extends Seeder
{
    public function run(): void
    {
        // Koordinat untuk simulasi perjalanan di Jakarta
        $routes = [
            // Rute untuk GPS-TRK-001 (gps_device_id = 1)
            [
                'gps_device_id' => 1,
                'coordinates' => [
                    ['latitude' => -6.175110, 'longitude' => 106.865036], // Jakarta Pusat
                    ['latitude' => -6.176110, 'longitude' => 106.866036],
                    ['latitude' => -6.177110, 'longitude' => 106.867036],
                    ['latitude' => -6.178110, 'longitude' => 106.868036],
                    ['latitude' => -6.179110, 'longitude' => 106.869036],
                ],
            ],
            // Rute untuk GPS-BUS-001 (gps_device_id = 2)
            [
                'gps_device_id' => 2,
                'coordinates' => [
                    ['latitude' => -6.200000, 'longitude' => 106.800000], // Jakarta Selatan
                    ['latitude' => -6.201000, 'longitude' => 106.801000],
                    ['latitude' => -6.202000, 'longitude' => 106.802000],
                    ['latitude' => -6.203000, 'longitude' => 106.803000],
                    ['latitude' => -6.204000, 'longitude' => 106.804000],
                ],
            ],
            // Rute untuk GPS-TRK-101 (gps_device_id = 4)
            [
                'gps_device_id' => 4,
                'coordinates' => [
                    ['latitude' => -6.150000, 'longitude' => 106.750000], // Jakarta Barat
                    ['latitude' => -6.151000, 'longitude' => 106.751000],
                    ['latitude' => -6.152000, 'longitude' => 106.752000],
                    ['latitude' => -6.153000, 'longitude' => 106.753000],
                    ['latitude' => -6.154000, 'longitude' => 106.754000],
                ],
            ],
        ];

        $now = Carbon::now();
        
        foreach ($routes as $route) {
            $gpsDeviceId = $route['gps_device_id'];
            $coordinates = $route['coordinates'];
            
            foreach ($coordinates as $index => $coordinate) {
                // Simulasi data tracking dengan interval 5 menit
                $timestamp = $now->copy()->subMinutes(($index + 1) * 5);
                
                GpsTrack::create([
                    'gps_device_id' => $gpsDeviceId,
                    'latitude' => $coordinate['latitude'],
                    'longitude' => $coordinate['longitude'],
                    'speed' => rand(0, 80), // Kecepatan acak antara 0-80 km/jam
                    'course' => rand(0, 360), // Arah acak 0-360 derajat
                    'direction' => rand(0, 360), // Arah dalam derajat (0-360)
                    'devices_timestamp' => $timestamp,
                ]);
            }
        }
    }
    
    // Fungsi getDirection dihapus karena kolom direction di database adalah float
}