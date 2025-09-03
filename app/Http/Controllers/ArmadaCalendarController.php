<?php

namespace App\Http\Controllers;

use App\Models\ArmadaCalendar;
use Illuminate\Http\Request;

class ArmadaCalendarController extends Controller
{
    // Ambil semua event
    public function index()
    {
        return response()->json(ArmadaCalendar::all());
    }

    // Simpan event baru
    public function store(Request $request)
    {
        $event = ArmadaCalendar::create($request->all());
        return response()->json($event);
    }

    // Update event
    public function update(Request $request, $id)
    {
        $event = ArmadaCalendar::findOrFail($id);
        $event->update($request->all());
        return response()->json($event);
    }

    // Hapus event
    public function destroy($id)
    {
        $event = ArmadaCalendar::findOrFail($id);
        $event->delete();
        return response()->json(['success' => true]);
    }
}
