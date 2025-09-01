<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FleetResource\Pages;
use App\Filament\Resources\FleetResource\RelationManagers;
use App\Models\Fleet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FleetResource extends Resource
{
    protected static ?string $model = Fleet::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    
    protected static ?string $navigationGroup = 'Kendaraan';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kendaraan')
                    ->description('Masukkan informasi detail kendaraan')
                    ->icon('heroicon-o-truck')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Kendaraan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan nama kendaraan')
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('plate_number')
                            ->label('Nomor Plat')
                            ->required()
                            ->maxLength(20)
                            ->placeholder('B 1234 ABC')
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('machine_number')
                            ->label('Nomor Mesin')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('Masukkan nomor mesin'),

                        Forms\Components\Select::make('company_id')
                            ->label('Perusahaan')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->visible(fn () => auth()->user()->hasRole('super_admin'))
                            ->default(
                                fn () => auth()->user()->hasRole('super_admin')
                                    ? null
                                    : auth()->user()->company_id
                            )
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('fleet_category_id', null);
                            }),

                        Forms\Components\Hidden::make('company_id')
                            ->default(fn () => auth()->user()->company_id)
                            ->visible(fn () => !auth()->user()->hasRole('super_admin')),

                        Forms\Components\Select::make('fleet_category_id')
                            ->label('Kategori Kendaraan')
                            ->relationship('category', 'name', function (Builder $query, callable $get) {
                                $companyId = $get('company_id');
                                if ($companyId) {
                                    $query->where('company_id', $companyId);
                                }
                                return $query;
                            })
                            ->required()
                            ->searchable()
                            ->preload(),
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

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kendaraan')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-truck')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('plate_number')
                    ->label('Nomor Plat')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-identification')
                    ->copyable(),

                Tables\Columns\TextColumn::make('machine_number')
                    ->label('Nomor Mesin')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-cog')
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company_id')
                    ->label('Perusahaan')
                    ->relationship('company', 'name')
                    ->preload()
                    ->searchable(),

                Tables\Filters\SelectFilter::make('fleet_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),
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
            'index' => Pages\ListFleets::route('/'),
            'create' => Pages\CreateFleet::route('/create'),
            'edit' => Pages\EditFleet::route('/{record}/edit'),
        ];
    }
}