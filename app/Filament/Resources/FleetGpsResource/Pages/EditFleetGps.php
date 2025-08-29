<?php

namespace App\Filament\Resources\FleetGpsResource\Pages;

use App\Filament\Resources\FleetGpsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFleetGps extends EditRecord
{
    protected static string $resource = FleetGpsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}