<?php

namespace App\Filament\Resources\FleetGpsResource\Pages;

use App\Filament\Resources\FleetGpsResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewFleetGps extends ViewRecord
{
    protected static string $resource = FleetGpsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
