<?php

namespace App\Filament\Resources\FleetCategoryResource\Pages;

use App\Filament\Resources\FleetCategoryResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewFleetCategory extends ViewRecord
{
    protected static string $resource = FleetCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
