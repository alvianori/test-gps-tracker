<?php

namespace App\Filament\Widgets;

use App\Models\Fleet;
use App\Models\Customer;
use App\Models\Company;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Fleet', Fleet::count())
                ->description('Jumlah seluruh armada')
                ->color('primary'),

            Stat::make('Total Customer', Customer::count())
                ->description('Jumlah seluruh customer')
                ->color('primary'),

            Stat::make('Total Company', Company::count())
                ->description('Jumlah seluruh perusahaan')
                ->color('primary')
        ];
    }
}