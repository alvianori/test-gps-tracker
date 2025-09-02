<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FleetCategoryResource\Pages;
use App\Filament\Resources\FleetCategoryResource\RelationManagers;
use App\Models\FleetCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FleetCategoryResource extends Resource
{
    protected static ?string $model = FleetCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Master Data';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kategori Kendaraan')
                    ->description('Masukkan informasi kategori kendaraan')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Kategori')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Contoh: SUV, Sedan, Truck')
                                ->unique(ignoreRecord: true)
                                ->prefixIcon('heroicon-o-tag')
                                ->helperText('Nama kategori kendaraan harus unik.'),
    
                            Forms\Components\Select::make('company_id')
                                ->label('Perusahaan')
                                ->relationship('company', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->prefixIcon('heroicon-o-building-office')
                                ->visible(fn() => auth()->user()->hasRole('super_admin'))
                                ->default(fn() => auth()->user()->hasRole('super_admin') ? null : auth()->user()->company_id),
                        ]),
    
                        Forms\Components\Hidden::make('company_id')
                            ->default(fn() => auth()->user()->company_id)
                            ->visible(fn() => !auth()->user()->hasRole('super_admin')),
    
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Masukkan deskripsi kategori kendaraan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rowIndex')
                    ->label('No')
                    ->rowIndex()
                    ->sortable(false),
    
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-tag'),
    
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
                    ->toggleable(),
    
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info'),
    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company_id')
                    ->label('Filter Perusahaan')
                    ->relationship('company', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ]);
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
            'index' => Pages\ListFleetCategories::route('/'),
            'create' => Pages\CreateFleetCategory::route('/create'),
            'edit' => Pages\EditFleetCategory::route('/{record}/edit'),
        ];
    }
}