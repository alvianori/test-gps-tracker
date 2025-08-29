<?php

namespace App\Filament\Resources\FleetGpsResource\Pages;

use App\Filament\Resources\FleetGpsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFleetGps extends CreateRecord
{
    protected static string $resource = FleetGpsResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}