<?php

namespace App\Filament\Resources\StaffPositionResource\Pages;

use App\Filament\Resources\StaffPositionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStaffPosition extends ViewRecord
{
    protected static string $resource = StaffPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
