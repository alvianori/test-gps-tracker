<?php

namespace App\Enums;

enum StatusArmada: string
{
    case AKTIF = 'aktif';
    case NONAKTIF = 'nonaktif';
    case MAINTENANCE = 'maintenance';

    // Label untuk ditampilkan di calendar
    public function label(): string
    {
        return match($this) {
            self::AKTIF => 'Aktif',
            self::NONAKTIF => 'Nonaktif',
            self::MAINTENANCE => 'Maintenance',
        };
    }

    // Warna untuk calendar
    public function color(): string
    {
        return match($this) {
            self::AKTIF => 'green',
            self::NONAKTIF => 'yellow',
            self::MAINTENANCE => 'red',
        };
    }
}
