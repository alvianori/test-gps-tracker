<?php

namespace App\Filament\Widgets;

use App\Models\GpsData;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestGpsActivityWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            // Mengambil 10 data terbaru dan relasi 'armada'
            ->query(GpsData::with('armada')->latest()->limit(10))
            ->columns([
                // Pastikan di model Armada ada kolom 'name' atau 'nopol'
                Tables\Columns\TextColumn::make('armada.name') 
                    ->label('Armada')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('speed')
                    ->label('Kecepatan (km/j)')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i:s'),
            ]);
    }
}