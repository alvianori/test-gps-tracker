<?php

namespace App\Filament\Resources\GpsDeviceResource\Pages;

use App\Filament\Resources\GpsDeviceResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewGpsDevice extends ViewRecord
{
    protected static string $resource = GpsDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
