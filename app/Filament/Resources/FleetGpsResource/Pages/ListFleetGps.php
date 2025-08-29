<?php

namespace App\Filament\Resources\FleetGpsResource\Pages;

use App\Filament\Resources\FleetGpsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFleetGps extends ListRecords
{
    protected static string $resource = FleetGpsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}