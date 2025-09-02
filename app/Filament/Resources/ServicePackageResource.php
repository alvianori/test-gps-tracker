<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicePackageResource\Pages;
use App\Models\ServicePackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ServicePackageResource extends Resource
{
    protected static ?string $model = ServicePackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('price')
                ->label('Price')
                ->prefix('Rp')
                ->numeric()
                ->required()
                ->reactive(),

            Forms\Components\Textarea::make('description')
                ->label('Description'),

            Forms\Components\Toggle::make('status')
                ->label('Active')
                ->default(true),

            // ✅ Checkbox untuk memilih fitur
            Forms\Components\CheckboxList::make('features')
                ->relationship('features', 'name')
                ->label('Features')
                ->columns(2) // Tampilkan dalam 2 kolom
                ->required()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Package Name')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('price')
                ->label('Price')
                ->money('idr'),

            // ✅ Menampilkan fitur dalam bentuk badge
            Tables\Columns\TextColumn::make('features.name')
                ->label('Features')
                ->badge()
                ->separator(', '),

            Tables\Columns\BooleanColumn::make('status')
                ->label('Active'),
        ])
        ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServicePackages::route('/'),
            'create' => Pages\CreateServicePackage::route('/create'),
            'edit' => Pages\EditServicePackage::route('/{record}/edit'),
        ];
    }
}
