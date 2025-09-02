<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FleetGpsResource\Pages;
use App\Models\FleetGps;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FleetGpsResource extends Resource
{
    protected static ?string $model = FleetGps::class;

    protected static ?string $navigationIcon = 'heroicon-o-signal';
    protected static ?string $navigationGroup = 'GPS Tracking';
    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Penugasan GPS';
    protected static ?string $pluralModelLabel = 'Penugasan GPS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Penugasan GPS')
                    ->description('Pilih kendaraan dan perangkat GPS untuk penugasan')
                    ->icon('heroicon-o-signal')
                    ->schema([
                        Forms\Components\Select::make('fleet_id')
                            ->label('Kendaraan')
                            ->relationship('fleet', 'name', function (Builder $query) {
                                if (!auth()->user()->hasRole('super_admin')) {
                                    $query->where('company_id', auth()->user()->company_id);
                                }
                                $assignedFleetIds = \App\Models\FleetGps::pluck('fleet_id')->toArray();
                                $query->whereNotIn('id', $assignedFleetIds);
                                return $query;
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2)
                            ->placeholder('Pilih kendaraan')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - {$record->plate_number}")
                            ->disabled(fn ($livewire) => $livewire instanceof Pages\EditFleetGps),

                        Forms\Components\Select::make('gps_device_id')
                            ->label('Perangkat GPS')
                            ->relationship('gpsDevice', 'name', function (Builder $query) {
                                if (!auth()->user()->hasRole('super_admin')) {
                                    $query->where('company_id', auth()->user()->company_id);
                                }
                                return $query;
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2)
                            ->placeholder('Pilih perangkat GPS')
                            ->helperText('Jika GPS sudah digunakan oleh kendaraan lain, kendaraan tersebut akan otomatis dinonaktifkan.'),

                        Forms\Components\Toggle::make('active')
                            ->label('Status Aktif')
                            ->default(true),

                        Forms\Components\DateTimePicker::make('assigned_at')
                            ->label('Tanggal Mulai Penugasan')
                            ->default(now())
                            ->required(),

                        Forms\Components\DateTimePicker::make('unassigned_at')
                            ->label('Tanggal Selesai Penugasan')
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rowIndex')
                    ->label('#')
                    ->rowIndex(),

                Tables\Columns\TextColumn::make('fleet.name')
                    ->label('Kendaraan')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-truck')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('fleet.plate_number')
                    ->label('Nomor Plat')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-identification')
                    ->copyable(),

                Tables\Columns\TextColumn::make('gpsDevice.name')
                    ->label('Perangkat GPS')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-cpu-chip'),

                Tables\Columns\TextColumn::make('gpsDevice.serial_number')
                    ->label('Nomor Seri')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-hashtag')
                    ->copyable(),

                Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Nonaktif')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('assigned_at')
                    ->label('Tanggal Mulai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('unassigned_at')
                    ->label('Tanggal Selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('fleet_id')
                    ->label('Kendaraan')
                    ->relationship('fleet', 'name', function (Builder $query) {
                        if (!auth()->user()->hasRole('super_admin')) {
                            $query->where('company_id', auth()->user()->company_id);
                        }
                        return $query;
                    })
                    ->searchable()
                    ->preload(),

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

                Tables\Filters\SelectFilter::make('active')
                    ->label('Status')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Tidak Aktif',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('activate')
                    ->label('Aktifkan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (FleetGps $record) => !$record->active)
                    ->action(fn (FleetGps $record) => $record->activate()),

                Tables\Actions\Action::make('deactivate')
                    ->label('Nonaktifkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (FleetGps $record) => $record->active)
                    ->action(fn (FleetGps $record) => $record->deactivate()),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            // ->bulkActions([
            //     Tables\Actions\BulkAction::make('activate')
            //         ->label('Aktifkan')
            //         ->icon('heroicon-o-check-circle')
            //         ->color('success')
            //         ->action(fn ($records) => $records->each->update(['active' => true])),

            //     Tables\Actions\BulkAction::make('deactivate')
            //         ->label('Nonaktifkan')
            //         ->icon('heroicon-o-x-circle')
            //         ->color('danger')
            //         ->action(fn ($records) => $records->each->update(['active' => false])),

            //     Tables\Actions\DeleteBulkAction::make(),
            // ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFleetGps::route('/'),
            'create' => Pages\CreateFleetGps::route('/create'),
            'edit' => Pages\EditFleetGps::route('/{record}/edit'),
        ];
    }
}