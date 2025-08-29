<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FleetUserResource\Pages;
use App\Models\FleetUser;
use App\Models\Fleet;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FleetUserResource extends Resource
{
    protected static ?string $model = FleetUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationGroup = 'Kendaraan';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $modelLabel = 'Penugasan Kendaraan';
    
    protected static ?string $pluralModelLabel = 'Penugasan Kendaraan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Penugasan Kendaraan')
                    ->description('Pilih kendaraan dan pengguna untuk penugasan')
                    ->icon('heroicon-o-truck')
                    ->schema([
                        Forms\Components\Select::make('fleet_id')
                            ->label('Kendaraan')
                            ->relationship('fleet', 'name', function (Builder $query) {
                                if (!auth()->user()->hasRole('super_admin')) {
                                    $query->where('company_id', auth()->user()->company_id);
                                }
                                // Filter kendaraan yang belum memiliki penugasan pengguna
                                $assignedFleetIds = \App\Models\FleetUser::pluck('fleet_id')->toArray();
                                $query->whereNotIn('id', $assignedFleetIds);
                                return $query;
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2)
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - {$record->plate_number}")
                            ->disabled(fn ($livewire) => $livewire instanceof Pages\EditFleetUser),
                        Forms\Components\Select::make('user_id')
                            ->label('Pengguna')
                            ->relationship('user', 'name', function (Builder $query) {
                                if (!auth()->user()->hasRole('super_admin')) {
                                    $query->where('company_id', auth()->user()->company_id);
                                }
                                return $query;
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2)
                            ->helperText('Jika pengguna sudah memiliki kendaraan aktif lain, kendaraan tersebut akan otomatis dinonaktifkan.'),
                        Forms\Components\Toggle::make('active')
                            ->label('Status Aktif')
                            ->required()
                            ->default(true),
                        Forms\Components\DateTimePicker::make('assigned_at')
                            ->label('Tanggal Mulai Penugasan')
                            ->required()
                            ->default(now()),
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
                Tables\Columns\TextColumn::make('fleet.name')
                    ->label('Kendaraan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('fleet.plate_number')
                    ->label('Nomor Plat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assigned_at')
                    ->label('Tanggal Mulai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unassigned_at')
                    ->label('Tanggal Selesai')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->placeholder('Belum selesai'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
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
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Pengguna')
                    ->relationship('user', 'name', function (Builder $query) {
                        if (!auth()->user()->hasRole('super_admin')) {
                            $query->where('company_id', auth()->user()->company_id);
                        }
                        return $query;
                    })
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('activate')
                    ->label('Aktifkan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (FleetUser $record) => !$record->active)
                    ->action(fn (FleetUser $record) => $record->activate()),
                Tables\Actions\Action::make('deactivate')
                    ->label('Nonaktifkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (FleetUser $record) => $record->active)
                    ->action(fn (FleetUser $record) => $record->deactivate()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->activate()),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->deactivate()),
                ]),
            ]);
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
            'index' => Pages\ListFleetUsers::route('/'),
            'create' => Pages\CreateFleetUser::route('/create'),
            'edit' => Pages\EditFleetUser::route('/{record}/edit'),
        ];
    }
}