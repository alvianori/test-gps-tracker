<?php

namespace App\Filament\Resources\CategoryCustomerResource\Pages;

use App\Filament\Resources\CategoryCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryCustomer extends EditRecord
{
    protected static string $resource = CategoryCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
