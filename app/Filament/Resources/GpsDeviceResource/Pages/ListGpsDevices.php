<?php

namespace App\Filament\Resources\GpsDeviceResource\Pages;

use App\Filament\Resources\GpsDeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGpsDevices extends ListRecords
{
    protected static string $resource = GpsDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}