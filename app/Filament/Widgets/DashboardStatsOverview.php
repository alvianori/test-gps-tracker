<?php

namespace App\Filament\Widgets;

use App\Models\Armada;
use App\Models\Customer;
use App\Models\GpsData;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Armada Online: jika mengirim data dalam 10 menit terakhir
        $onlineArmadaCount = Armada::where('status', 'Aktif')->count();
            
        // Armada Bergerak: jika data terakhir kecepatannya > 5 km/j
        $movingArmadaCount = GpsData::where('created_at', '>', now()->subMinutes(10))
            ->where('speed', '>', 5)
            ->distinct('device_id') // <-- INI DIA KOLOM YANG BENAR
            ->count();

        return [
            Stat::make('Total Armada', Armada::count())
                ->description('Jumlah semua kendaraan')
                ->icon('heroicon-o-truck')
                ->color('primary'),

                Stat::make('Armada Online', $onlineArmadaCount)
                ->description('status di tabel armada')
                ->icon('heroicon-o-signal')
                ->color('success'),

            Stat::make('Armada Bergerak', $movingArmadaCount)
                ->description('Kecepatan > 5 km/j')
                ->icon('heroicon-o-paper-airplane')
                ->color('warning'),
            
            Stat::make('Total Customer', Customer::count())
                ->description('Jumlah pelanggan terdaftar')
                ->icon('heroicon-o-user-group')
                ->color('gray'),
        ];
    }
}