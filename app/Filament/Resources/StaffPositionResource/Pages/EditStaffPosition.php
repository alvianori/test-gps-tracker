<?php

namespace App\Filament\Resources\StaffPositionResource\Pages;

use App\Filament\Resources\StaffPositionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStaffPosition extends EditRecord
{
    protected static string $resource = StaffPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
