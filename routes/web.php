<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/kanban/task', function (Request $request) {
    Task::create([
        'title' => $request->input('title'),
        'status' => $request->input('status', 'todo'),      
    ]);
    return response()->json(['success' => true]);
});