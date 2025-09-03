<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\CalendarWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    // Taruh Calendar di HEADER
    public function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class, // Calendar akan tetap paling atas section ini
        ];
    }

    // Taruh Stats di BODY agar muncul di bawah header
    public function getWidgets(): array
    {
        return [
            DashboardStats::class,
        ];
    }
}
