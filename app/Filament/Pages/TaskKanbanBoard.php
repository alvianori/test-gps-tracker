<?php

namespace App\Filament\Pages;

use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
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


    protected function getStatusLabels(): array
    {
        return [
            'todo' => 'To Do',
            'in_progress' => 'In Progress',
            'done' => 'Done',
        ];
    }

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

    public function deleteTask($id)
    {
        Task::find($id)?->delete();

        $this->dispatch('notify', type: 'success', message: 'Task berhasil dihapus');
    }

    // Update data saat drag atau edit
    protected function editRecord(int|string $recordId, array $data, array $state): void
    {
        Task::findOrFail($recordId)->update([
            'title' => $data['title'],
        ]);
    }

    // Form edit modal
    protected function getEditModalFormSchema(int|string|null $recordId): array
    {
        return [
            TextInput::make('title')
                ->label('Judul Tugas')
                ->required(),
        ];
    }
}

//     <script>
// function openNewTaskModal() {
//     Swal.fire({
//         title: 'Buat Tugas Baru',
//         input: 'text',
//         inputLabel: 'Judul Tugas',
//         inputPlaceholder: 'Masukkan judul tugas',
//         showCancelButton: true,
//         confirmButtonText: 'Simpan',
//         cancelButtonText: 'Batal',
//         inputValidator: (value) => {
//             if (!value) {
//                 return 'Judul tidak boleh kosong!';
//             }
//         },
//         preConfirm: (title) => {
//             return fetch(`/kanban/task`, {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                 },
//                 body: JSON.stringify({ title: title, status: 'To Do' })
//             })
//             .then(response => {
//                 if (!response.ok) throw new Error(response.statusText);
//                 return response.json();
//             })
//             .catch(error => {
//                 Swal.showValidationMessage(`Request gagal: ${error}`);
//             });
//         }
//     }).then((result) => {
//         if (result.isConfirmed) {
//             Swal.fire('Berhasil!', 'Tugas baru ditambahkan.', 'success')
//                 .then(() => window.location.reload());
//         }
//     });
// }

// </script>
// <div
//     id="{{ $record->getKey() }}"
//     wire:click="recordClicked('{{ $record->getKey() }}', {{ @json_encode($record) }})"
//     class="record bg-white dark:bg-gray-700 rounded-lg px-4 py-2 cursor-grab font-medium text-gray-600 dark:text-gray-200 flex justify-between items-center"
//     @if($record->timestamps && now()->diffInSeconds($record->{$record::UPDATED_AT}, true) < 3)
//         x-data
//         x-init="
//             $el.classList.add('animate-pulse-twice', 'bg-primary-100', 'dark:bg-primary-800')
//             $el.classList.remove('bg-white', 'dark:bg-gray-700')
//             setTimeout(() => {
//                 $el.classList.remove('bg-primary-100', 'dark:bg-primary-800')
//                 $el.classList.add('bg-white', 'dark:bg-gray-700')
//             }, 3000)
//         "
//     @endif
// >
//     <span>{{ $record->{static::$recordTitleAttribute} }}</span>
//     <button
//         onclick="event.stopPropagation(); confirmDelete({{ $record->getKey() }})"
//         class="text-red-500 hover:text-red-700"
//     >
//         🗑
//     </button>
// </div>

// <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
// <script>
// function confirmDelete(id) {
//     Swal.fire({
//         title: 'Yakin hapus?',
//         text: "Data ini tidak bisa dikembalikan!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#d33',
//         cancelButtonColor: '#3085d6',
//         confirmButtonText: 'Ya, hapus!',
//         cancelButtonText: 'Batal'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             fetch(`/kanban/task/${id}`, {
//                 method: 'DELETE',
//                 headers: {
//                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
//                 }
//             }).then(() => {
//                 Swal.fire('Berhasil!', 'Data telah dihapus.', 'success')
//                     .then(() => window.location.reload());
//             });
//         }
//     });
// }
// </script>