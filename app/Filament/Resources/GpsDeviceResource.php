<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GpsDeviceResource\Pages;
use App\Models\GpsDevice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GpsDeviceResource extends Resource
{
    protected static ?string $model = GpsDevice::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';
    
    protected static ?string $navigationGroup = 'GPS Tracking';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Perangkat GPS')
                    ->description('Masukkan informasi detail perangkat GPS')
                    ->icon('heroicon-o-device-phone-mobile')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Perangkat')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan nama perangkat GPS'),
                        Forms\Components\TextInput::make('serial_number')
                            ->label('Nomor Seri')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan nomor seri perangkat')
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('model')
                            ->label('Model')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan model perangkat'),
                        Forms\Components\TextInput::make('provider')
                            ->label('Penyedia')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan nama penyedia perangkat'),
                        Forms\Components\Select::make('company_id')
                            ->label('Perusahaan')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->visible(fn() => auth()->user()->hasRole('super_admin'))
                            ->default(fn() => auth()->user()->hasRole('super_admin') ? null : auth()->user()->company_id),
                        Forms\Components\Hidden::make('company_id')
                            ->default(fn() => auth()->user()->company_id)
                            ->visible(fn() => !auth()->user()->hasRole('super_admin')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Perangkat')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-device-phone-mobile'),
                Tables\Columns\TextColumn::make('serial_number')
                    ->label('Nomor Seri')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('model')
                    ->label('Model')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('provider')
                    ->label('Penyedia')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company_id')
                    ->label('Perusahaan')
                    ->relationship('company', 'name')
                    ->preload()
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListGpsDevices::route('/'),
            'create' => Pages\CreateGpsDevice::route('/create'),
            'edit' => Pages\EditGpsDevice::route('/{record}/edit'),
        ];
    }
}