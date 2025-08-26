<?php

namespace App\Filament\Resources\StaffCompanyResource\Pages;

use App\Filament\Resources\StaffCompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStaffCompany extends EditRecord
{
    protected static string $resource = StaffCompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
