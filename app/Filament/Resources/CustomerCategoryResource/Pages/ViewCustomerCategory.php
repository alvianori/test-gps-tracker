<?php

namespace App\Filament\Resources\CustomerCategoryResource\Pages;

use App\Filament\Resources\CustomerCategoryResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewCustomerCategory extends ViewRecord
{
    protected static string $resource = CustomerCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
