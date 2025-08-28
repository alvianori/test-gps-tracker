<?php

namespace App\Filament\Resources\FleetCategoryResource\Pages;

use App\Filament\Resources\FleetCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFleetCategory extends EditRecord
{
    protected static string $resource = FleetCategoryResource::class;

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
