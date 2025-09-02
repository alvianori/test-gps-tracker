<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create(['title' => 'Membuat UI Kanban', 'status' => 'todo']);
        Task::create(['title' => 'Integrasi SweetAlert', 'status' => 'in_progress']);
        Task::create(['title' => 'Testing Aplikasi', 'status' => 'done']);
    }
}
