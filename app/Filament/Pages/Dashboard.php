<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardStatsOverview;
use App\Filament\Widgets\LatestGpsActivityWidget;
use App\Filament\Widgets\UsersChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            DashboardStatsOverview::class,
            UsersChart::class,
            LatestGpsActivity::class,
        ];
    }
}