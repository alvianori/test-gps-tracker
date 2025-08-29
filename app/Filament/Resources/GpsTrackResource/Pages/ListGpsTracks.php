<?php

namespace App\Filament\Resources\GpsTrackResource\Pages;

use App\Filament\Resources\GpsTrackResource;
use Filament\Resources\Pages\ListRecords;

class ListGpsTracks extends ListRecords
{
    protected static string $resource = GpsTrackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action as this is view-only
        ];
    }
}