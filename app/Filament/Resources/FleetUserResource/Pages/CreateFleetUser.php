<?php

namespace App\Filament\Resources\FleetUserResource\Pages;

use App\Filament\Resources\FleetUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFleetUser extends CreateRecord
{
    protected static string $resource = FleetUserResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}