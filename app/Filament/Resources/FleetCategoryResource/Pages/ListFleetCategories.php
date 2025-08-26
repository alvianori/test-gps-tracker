<?php

namespace App\Filament\Resources\FleetCategoryResource\Pages;

use App\Filament\Resources\FleetCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFleetCategories extends ListRecords
{
    protected static string $resource = FleetCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
