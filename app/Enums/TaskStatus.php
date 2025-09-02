<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum TaskStatus: string
{
    use IsKanbanStatus;

    case Todo = 'todo';
    case InProgress = 'in_progress';
    case Done = 'done';

    public function label(): string
    {
        return match ($this) {
            self::Todo => 'To Do',
            self::InProgress => 'In Progress',
            self::Done => 'Done',
        };
    }
}
