<?php

namespace App\Filament\Resources\FleetResource\Pages;

use App\Filament\Resources\FleetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFleet extends CreateRecord
{
    protected static string $resource = FleetResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
