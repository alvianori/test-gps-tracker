<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GpsTrackResource\Pages;
use App\Models\GpsTrack;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GpsTrackResource extends Resource
{
    protected static ?string $model = GpsTrack::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    
    protected static ?string $navigationGroup = 'GPS Tracking';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $modelLabel = 'Data GPS';
    
    protected static ?string $pluralModelLabel = 'Data GPS';
    
    public static function canCreate(): bool
    {
        // Disable create functionality as data will be received from IoT
        return false;
    }
    
    public static function canEdit($record): bool
    {
        // Disable edit functionality as data should be read-only
        return false;
    }
    
    public static function canDelete($record): bool
    {
        // Disable delete functionality as data should be preserved
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form is not needed as this is view-only
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('gpsDevice.name')
                    ->label('Perangkat GPS')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('gpsDevice.company.name')
                    ->label('Perusahaan')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('latitude')
                    ->label('Latitude')
                    ->sortable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('longitude')
                    ->label('Longitude')
                    ->sortable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('speed')
                    ->label('Kecepatan (km/jam)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('direction')
                    ->label('Arah')
                    ->sortable(),

                Tables\Columns\TextColumn::make('devices_timestamp')
                    ->label('Waktu Perangkat')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diterima Server')
                    ->dateTime('d M Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gps_device_id')
                    ->label('Perangkat GPS')
                    ->relationship('gpsDevice', 'name', function (Builder $query) {
                        if (!auth()->user()->hasRole('super_admin')) {
                            $query->where('company_id', auth()->user()->company_id);
                        }
                        return $query;
                    })
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('devices_timestamp')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('devices_timestamp', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('devices_timestamp', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail'),
            ])
            ->bulkActions([])
            ->defaultSort('devices_timestamp', 'desc');
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGpsTracks::route('/'),
            'view' => Pages\ViewGpsTrack::route('/{record}'),
        ];
    }
}