<?php

namespace App\Filament\Resources\FleetCategoryResource\Pages;

use App\Filament\Resources\FleetCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFleetCategory extends CreateRecord
{
    protected static string $resource = FleetCategoryResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
