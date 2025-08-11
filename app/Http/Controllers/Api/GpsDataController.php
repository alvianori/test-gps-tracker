<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GpsData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class GpsDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(GpsData::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validasi input
        $validated = $request->validate([
            'device_id' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'speed' => 'nullable|numeric',
            'course' => 'nullable|numeric',
            'direction' => 'nullable|string',
            'devices_timestamp' => 'required|date',
        ]);

        // Simpan data GPS
        $gpsData = GpsData::create($validated);

        return response()->json([
            'message' => 'Data saved',
            'data' => $gpsData
        ], 201);
    }

    // Endpoint bulk - kirim banyak data sekaligus
    public function storeBulk(Request $request)
    {
        try {
            $validated = $request->validate([
                'device_id' => 'required|string',
                'data' => 'required|array',
                'data.*.latitude' => 'required|numeric',
                'data.*.longitude' => 'required|numeric',
                'data.*.speed' => 'nullable|numeric',
                'data.*.course' => 'nullable|numeric',
                'data.*.direction' => 'nullable|string',
                'data.*.devices_timestamp' => 'required|date',
            ]);

            $insertData = [];
            foreach ($validated['data'] as $row) {
                $insertData[] = [
                    'device_id' => $validated['device_id'],
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                    'speed' => $row['speed'] ?? null,
                    'course' => $row['course'] ?? null,
                    'direction' => $row['direction'] ?? null,
                    'devices_timestamp' => Carbon::parse($row['devices_timestamp'])->format('Y-m-d H:i:s'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            GpsData::insert($insertData);

            return response()->json([
                'message' => 'Bulk data stored successfully',
                'inserted_count' => count($insertData),
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = GpsData::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function latestData(Request $request)
    {
        $deviceId = $request->query('device_id');

        $query = GpsData::query();

        // Filter jika ada device_id
        if ($deviceId) {
            $query->where('device_id', $deviceId);
        }

        // Ambil data terbaru
        $latest = $query->orderBy('created_at', 'desc')->first();

        if (!$latest) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json($latest);
    }

    public function byDeviceId($deviceId)
    {
        $data = GpsData::where('device_id', $deviceId)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Data not found for device_id: ' . $deviceId
            ], 404);
        }

        return response()->json($data, 200);
    }


    public function filterByDate(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
            'type' => 'required|in:daily,weekly,monthly,yearly,custom',
        ]);

        $deviceId = $validated['device_id'];
        $type = $validated['type'];
        $query = GpsData::where('device_id', $deviceId);
        $now = Carbon::now('UTC'); // Ubah timezone jadi UTC

        try {
            switch ($type) {
                case 'daily':
                    $query->whereDate('created_at', $now->toDateString());
                    break;

                case 'weekly':
                    $query->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()]);
                    break;

                case 'monthly':
                    $query->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()]);
                    break;

                case 'yearly':
                    $query->whereBetween('created_at', [$now->copy()->startOfYear(), $now->copy()->endOfYear()]);
                    break;

                case 'custom':
                    $start = $request->query('start');
                    $end = $request->query('end');

                    if (!$start || !$end) {
                        return response()->json(['message' => 'start and end are required for custom type'], 400);
                    }

                    $startDate = Carbon::parse($start, 'UTC');
                    $endDate = Carbon::parse($end, 'UTC')->endOfDay(); // agar termasuk seluruh hari

                    if ($startDate->gt($endDate)) {
                        return response()->json(['message' => 'Start date must be before end date'], 400);
                    }

                    $query->whereBetween('created_at', [$startDate, $endDate]);
                    break;
            }
        } catch (\Exception $e) {
            Log::error('Date parsing error: ' . $e->getMessage());
            return response()->json(['message' => 'Invalid date format'], 400);
        }

        $data = $query->orderBy('created_at', 'asc')->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No data found for the selected filter'], 404);
        }

        return response()->json($data);
    }
}
