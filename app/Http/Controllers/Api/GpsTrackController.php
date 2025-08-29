<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GpsTrack;
use App\Models\GpsDevice;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class GpsTrackController extends Controller
{
    /**
     * Konversi direction dari string ke float
     */
    private function convertDirection($direction)
    {
        if (is_string($direction)) {
            // Konversi arah mata angin ke derajat
            $directionMap = [
                'N' => 0,    // North
                'NE' => 45,  // Northeast
                'E' => 90,   // East
                'SE' => 135, // Southeast
                'S' => 180,  // South
                'SW' => 225, // Southwest
                'W' => 270,  // West
                'NW' => 315, // Northwest
            ];
            return $directionMap[strtoupper($direction)] ?? 0;
        }
        
        return $direction;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'device_code' => 'required|string|exists:gps_devices,code',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed' => 'nullable|numeric|min:0',
            'course' => 'nullable|numeric|between:0,360',
            'direction' => 'nullable',
            'devices_timestamp' => 'required|date_format:Y-m-d H:i:s',
        ], [
            'device_code.exists' => 'GPS device dengan kode tersebut tidak ditemukan.',
            'devices_timestamp.date_format' => 'Format timestamp harus Y-m-d H:i:s (contoh: 2024-01-15 10:30:00).'
        ]);

        // Cari GPS device berdasarkan code
        // Gunakan withoutGlobalScopes() untuk melewati CompanyScope karena API ini diakses tanpa autentikasi
        $gpsDevice = GpsDevice::withoutGlobalScopes()->where('code', $validated['device_code'])->first();

        // Konversi direction menggunakan helper method
        $direction = $this->convertDirection($validated['direction']);
        
        // Simpan data GPS track
        $gpsTrack = GpsTrack::create([
            'gps_device_id' => $gpsDevice->id,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'speed' => $validated['speed'],
            'course' => $validated['course'],
            'direction' => $direction,
            'devices_timestamp' => $validated['devices_timestamp'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data GPS track berhasil disimpan',
            'data' => [
                'id' => $gpsTrack->id,
                'device_code' => $validated['device_code'],
                'latitude' => $gpsTrack->latitude,
                'longitude' => $gpsTrack->longitude,
                'speed' => $gpsTrack->speed,
                'course' => $gpsTrack->course,
                'direction' => $gpsTrack->direction,
                'devices_timestamp' => $gpsTrack->devices_timestamp,
                'created_at' => $gpsTrack->created_at,
            ]
        ], 201);
    }

    // Endpoint bulk - kirim banyak data sekaligus
    public function storeBulk(Request $request)
    {
        try {
            $validated = $request->validate([
                'device_code' => 'required|string|exists:gps_devices,code',
                'data' => 'required|array|min:1|max:100',
                'data.*.latitude' => 'required|numeric|between:-90,90',
                'data.*.longitude' => 'required|numeric|between:-180,180',
                'data.*.speed' => 'nullable|numeric|min:0',
                'data.*.course' => 'nullable|numeric|between:0,360',
                'data.*.direction' => 'nullable',
                'data.*.devices_timestamp' => 'required|date_format:Y-m-d H:i:s',
            ], [
                'device_code.exists' => 'GPS device dengan kode tersebut tidak ditemukan.',
                'data.*.devices_timestamp.date_format' => 'Format timestamp harus Y-m-d H:i:s (contoh: 2024-01-15 10:30:00).'
            ]);

            // Cari GPS device berdasarkan code
            $gpsDevice = GpsDevice::withoutGlobalScopes()->where('code', $validated['device_code'])->first();

            $insertData = [];
            foreach ($validated['data'] as $row) {
                $insertData[] = [
                    'gps_device_id' => $gpsDevice->id,
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                    'speed' => $row['speed'] ?? null,
                    'course' => $row['course'] ?? null,
                    'direction' => $this->convertDirection($row['direction'] ?? null),
                    'devices_timestamp' => $row['devices_timestamp'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            GpsTrack::insert($insertData);

            return response()->json([
                'success' => true,
                'message' => 'Data GPS track bulk berhasil disimpan',
                'data' => [
                    'device_code' => $validated['device_code'],
                    'inserted_count' => count($insertData),
                    'timestamp' => now()->toISOString()
                ]
            ], 201);
        } catch (\Throwable $e) {
            Log::error('GPS Track Bulk Store Error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function latestData(Request $request)
    {
        $deviceCode = $request->query('device_code');

        $query = GpsTrack::with('gpsDevice');

        // Filter jika ada device_code
        if ($deviceCode) {
            $gpsDevice = GpsDevice::withoutGlobalScopes()->where('code', $deviceCode)->first();

            if (!$gpsDevice) {
                return response()->json([
                    'success' => false,
                    'message' => 'GPS device tidak ditemukan dengan kode: ' . $deviceCode
                ], 404);
            }

            $query->where('gps_device_id', $gpsDevice->id);
        }

        // Ambil data terbaru
        $latest = $query->orderBy('devices_timestamp', 'desc')->first();

        if (!$latest) {
            return response()->json([
                'success' => false,
                'message' => 'Data GPS track tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $latest->id,
                'latitude' => $latest->latitude,
                'longitude' => $latest->longitude,
                'speed' => $latest->speed,
                'course' => $latest->course,
                'direction' => $latest->direction,
                'devices_timestamp' => $latest->devices_timestamp,
                'device_info' => [
                    'code' => $latest->gpsDevice->code,
                    'name' => $latest->gpsDevice->name,
                    'provider' => $latest->gpsDevice->provider
                ]
            ]
        ], 200);
    }

    public function byDeviceCode($deviceCode)
    {
        $gpsDevice = GpsDevice::withoutGlobalScopes()->where('code', $deviceCode)->first();

        if (!$gpsDevice) {
            return response()->json([
                'success' => false,
                'message' => 'GPS device tidak ditemukan dengan kode: ' . $deviceCode
            ], 404);
        }

        $tracks = GpsTrack::where('gps_device_id', $gpsDevice->id)
            ->orderBy('devices_timestamp', 'desc')
            ->limit(100) // Batasi hasil untuk performa
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tracks,
            'device_info' => [
                'code' => $gpsDevice->code,
                'name' => $gpsDevice->name,
                'provider' => $gpsDevice->provider
            ]
        ], 200);
    }

    public function filterByDate(Request $request)
    {
        $validated = $request->validate([
            'device_code' => 'required|string|exists:gps_devices,code',
            'type' => 'required|in:daily,weekly,monthly,yearly,custom,all',
        ], [
            'device_code.exists' => 'GPS device dengan kode tersebut tidak ditemukan.'
        ]);

        $deviceCode = $validated['device_code'];
        $type = $validated['type'];

        $gpsDevice = GpsDevice::withoutGlobalScopes()->where('code', $deviceCode)->first();

        $query = GpsTrack::where('gps_device_id', $gpsDevice->id);
        $now = Carbon::now('UTC'); // Ubah timezone jadi UTC

        try {
            switch ($type) {
                case 'daily':
                    $query->whereDate('devices_timestamp', $now->toDateString());
                    break;

                case 'weekly':
                    $query->whereBetween('devices_timestamp', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()]);
                    break;

                case 'monthly':
                    $query->whereBetween('devices_timestamp', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()]);
                    break;

                case 'yearly':
                    $query->whereBetween('devices_timestamp', [$now->copy()->startOfYear(), $now->copy()->endOfYear()]);
                    break;
                    
                case 'all':
                    // Tidak perlu filter tambahan, ambil semua data
                    break;

                case 'custom':
                    $start = $request->input('start_date');
                    $end = $request->input('end_date');

                    if (!$start || !$end) {
                        return response()->json(['message' => 'Parameter start_date dan end_date diperlukan untuk tipe custom'], 400);
                    }

                    $startDate = Carbon::parse($start, 'UTC');
                    $endDate = Carbon::parse($end, 'UTC')->endOfDay(); // agar termasuk seluruh hari

                    if ($startDate->gt($endDate)) {
                        return response()->json(['message' => 'Tanggal awal harus sebelum tanggal akhir'], 400);
                    }

                    $query->whereBetween('devices_timestamp', [$startDate, $endDate]);
                    break;
            }
        } catch (\Exception $e) {
            Log::error('Date parsing error: ' . $e->getMessage());
            return response()->json(['message' => 'Format tanggal tidak valid'], 400);
        }

        $data = $query->orderBy('devices_timestamp', 'desc')->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data untuk filter yang dipilih'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'device_info' => [
                'code' => $gpsDevice->code,
                'name' => $gpsDevice->name,
                'provider' => $gpsDevice->provider
            ]
        ]);
    }
}
