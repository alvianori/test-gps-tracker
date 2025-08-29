<?php

namespace App\Filament\Resources\FleetUserResource\Pages;

use App\Filament\Resources\FleetUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFleetUser extends EditRecord
{
    protected static string $resource = FleetUserResource::class;

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