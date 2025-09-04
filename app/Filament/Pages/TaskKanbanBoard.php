<?php

namespace App\Filament\Pages;

use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use Filament\Forms\Components\TextInput;
use Filament\Actions;
use App\Models\Task;
use App\Enums\TaskStatus;
use Filament\Notifications\Notification;

class TaskKanbanBoard extends KanbanBoard
{
    protected static string $model = Task::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static string $statusEnum = TaskStatus::class;
    protected $listeners = ['deleteTask'];

    /**
     * Label kolom kanban
     */
    protected function getStatusLabels(): array
    {
        return [
            TaskStatus::Todo->value => TaskStatus::Todo->label(),
            TaskStatus::InProgress->value => TaskStatus::InProgress->label(),
            TaskStatus::Done->value => TaskStatus::Done->label(),
        ];
    }

    /**
     * Warna card berdasarkan status
     */
    protected function getRecordClasses($record): array|string|null
    {
        return match ($record->status) {
            TaskStatus::Todo->value => 'bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-100',
            TaskStatus::InProgress->value => 'bg-yellow-200 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100',
            TaskStatus::Done->value => 'bg-green-200 text-green-800 dark:bg-green-600 dark:text-green-100',
            default => 'bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200',
        };
    }

    /**
     * Warna header kolom berdasarkan status
     */
    protected function getStatusClasses(string $status): string
    {
        return match ($status) {
            TaskStatus::Todo->value => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
            TaskStatus::InProgress->value => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-200',
            TaskStatus::Done->value => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-200',
            default => 'bg-slate-100 text-slate-800',
        };
    }

    /**
     * Action untuk membuat task baru
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->model(Task::class)
                ->label('Add New Task')
                ->modalHeading('Create New Task')
                ->form([
                    TextInput::make('title')
                        ->label('Task Title')
                        ->required(),
                ])
                ->after(function ($record) {
                    Notification::make()
                        ->title('Task Created!')
                        ->body("Task '{$record->title}' berhasil dibuat.")
                        ->success()
                        ->send();
                }),
        ];
    }

    /**
     * Hapus task
     */
    public function deleteTask($id)
    {
        Task::find($id)?->delete();

        $this->dispatch('notify', type: 'success', message: 'Task berhasil dihapus');
    }

    /**
     * Update data saat drag atau edit
     */
    protected function editRecord(int|string $recordId, array $data, array $state): void
    {
        Task::findOrFail($recordId)->update([
            'title' => $data['title'],
        ]);
    }

    /**
     * Schema form edit
     */
    protected function getEditModalFormSchema(int|string|null $recordId): array
    {
        return [
            TextInput::make('title')
                ->label('Judul Tugas')
                ->required(),
        ];
    }
}