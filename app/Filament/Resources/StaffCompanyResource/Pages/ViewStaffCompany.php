<?php

namespace App\Filament\Resources\StaffCompanyResource\Pages;

use App\Filament\Resources\StaffCompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStaffCompany extends ViewRecord
{
    protected static string $resource = StaffCompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
