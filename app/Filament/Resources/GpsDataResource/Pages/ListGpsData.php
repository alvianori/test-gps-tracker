<?php

namespace App\Filament\Resources\GpsDataResource\Pages;

use App\Filament\Resources\GpsDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGpsData extends ListRecords
{
    protected static string $resource = GpsDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
