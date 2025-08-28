<?php

namespace App\Filament\Resources\GpsDeviceResource\Pages;

use App\Filament\Resources\GpsDeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGpsDevice extends CreateRecord
{
    protected static string $resource = GpsDeviceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}