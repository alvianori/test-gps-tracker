<?php

namespace App\Filament\Resources\FleetUserResource\Pages;

use App\Filament\Resources\FleetUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFleetUsers extends ListRecords
{
    protected static string $resource = FleetUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}