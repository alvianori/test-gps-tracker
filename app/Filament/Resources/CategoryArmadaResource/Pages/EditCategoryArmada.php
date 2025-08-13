<?php

namespace App\Filament\Resources\CategoryArmadaResource\Pages;

use App\Filament\Resources\CategoryArmadaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryArmada extends EditRecord
{
    protected static string $resource = CategoryArmadaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
