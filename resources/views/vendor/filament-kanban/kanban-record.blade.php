@php
    $status = strtolower(trim($record->status));

    $bgColorClass = match ($status) {
        'in progress' => 'bg-yellow-200',
        'done' => 'bg-green-200',
        default => 'bg-gray-200', // todo / lainnya
    };
@endphp

<div
    id="{{ $record->getKey() }}"
    wire:click="recordClicked('{{ $record->getKey() }}', {{ json_encode($record) }})"
    class="record {{ $bgColorClass }} rounded-lg px-4 py-2 cursor-grab font-medium text-gray-700 flex justify-between items-center"
>
    <span>{{ $record->{static::$recordTitleAttribute} }}</span>
    <button
        onclick="event.stopPropagation(); confirmDelete({{ $record->getKey() }})"
        class="text-red-500 hover:text-red-700"
    >
        🗑
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Yakin hapus?',
        text: "Task ini tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'swal2-confirm-btn',
            cancelButton: 'swal2-cancel-btn'
        },
        didOpen: () => {
            // pastikan swal selalu di atas modal/filament
            document.querySelector('.swal2-container').style.zIndex = 99999;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch('deleteTask', { id: id });
            Swal.fire('Berhasil!', 'Task telah dihapus.', 'success');
        }
    });
}
</script>

<style>
.swal2-confirm-btn, .swal2-cancel-btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 600;
}
.swal2-confirm-btn {
    background-color: #d33 !important;
    color: #fff !important;
}
.swal2-cancel-btn {
    background-color: #3085d6 !important;
    color: #fff !important;
}
</style>
