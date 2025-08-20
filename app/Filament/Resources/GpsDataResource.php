<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GpsDataResource\Pages;
use App\Filament\Resources\GpsDataResource\RelationManagers;
use App\Models\GpsData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use App\Filament\Clusters\MasterData;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GpsDataResource extends Resource
{
    protected static ?string $model = GpsData::class;
    protected static ?string $cluster = MasterData::class;
    public static function getNavigationGroup(): ?string
    {
        return 'Manage Device';
    }

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationLabel = 'GPS Data';
    protected static ?string $navigationGroup = 'Tracking';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('device_id')->required(),
                Forms\Components\TextInput::make('latitude')->required(),
                Forms\Components\TextInput::make('longitude')->required(),
                Forms\Components\TextInput::make('speed'),
                Forms\Components\TextInput::make('course'),
                Forms\Components\TextInput::make('direction'),
                Forms\Components\DateTimePicker::make('devices_timestamp'),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => 
                $query->latest()->limit(100) 
            )
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('device_id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('latitude'),
                Tables\Columns\TextColumn::make('longitude'),
                Tables\Columns\TextColumn::make('speed'),
                Tables\Columns\TextColumn::make('direction'),
                Tables\Columns\TextColumn::make('devices_timestamp')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListGpsData::route('/'),
            'create' => Pages\CreateGpsData::route('/create'),
            'edit' => Pages\EditGpsData::route('/{record}/edit'),
        ];
    }
}
