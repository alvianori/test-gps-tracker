<?php

namespace App\Filament\Resources\GpsDeviceResource\Pages;

use App\Filament\Resources\GpsDeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGpsDevice extends EditRecord
{
    protected static string $resource = GpsDeviceResource::class;

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