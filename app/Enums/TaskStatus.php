<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum TaskStatus: string
{
    use IsKanbanStatus;

    case Todo = 'todo';          // Rute dijadwalkan
    case InProgress = 'in_progress'; // Armada sedang berjalan
    case Done = 'done';          // Rute selesai
}
