<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryArmadaResource\Pages;
use App\Filament\Resources\CategoryArmadaResource\RelationManagers;
use App\Models\CategoryArmada;
use App\Filament\Clusters\MasterData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryArmadaResource extends Resource
{
    protected static ?string $model = CategoryArmada::class;
    protected static ?string $cluster = MasterData::class;
    public static function getNavigationGroup(): ?string
    {
        return 'Manage Armada';
    }
    public static function getNavigationSort(): ?int
    {
        return 1; 
    }
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Kategori Armada';
    protected static ?string $pluralModelLabel = 'Kategori Armada';
    protected static ?string $modelLabel = 'Kategori Armada';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_category_armada')
                    ->label('Kategori Armada')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_category_armada')
                    ->label('Nama Kategori Armada')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListCategoryArmadas::route('/'),
            'create' => Pages\CreateCategoryArmada::route('/create'),
            'edit' => Pages\EditCategoryArmada::route('/{record}/edit'),
        ];
    }
}
