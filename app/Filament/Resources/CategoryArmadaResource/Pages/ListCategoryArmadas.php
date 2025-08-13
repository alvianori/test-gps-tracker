<?php

namespace App\Filament\Resources\CategoryArmadaResource\Pages;

use App\Filament\Resources\CategoryArmadaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryArmadas extends ListRecords
{
    protected static string $resource = CategoryArmadaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
