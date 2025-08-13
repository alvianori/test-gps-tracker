<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\MasterData;
use App\Filament\Resources\ArmadaResource\Pages;
use App\Filament\Resources\ArmadaResource\RelationManagers;
use App\Models\Armada;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArmadaResource extends Resource
{
    protected static ?string $model = Armada::class;
    protected static ?string $cluster = MasterData::class;
    public static function getNavigationGroup(): ?string
    {
        return 'Manage Armada';
    }
    public static function getNavigationSort(): ?int
    {
        return 2; 
    }
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Armada';
    protected static ?string $pluralModelLabel = 'Armada';
    protected static ?string $modelLabel = 'Armada';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_armada_id')
                    ->relationship('categoryArmada', 'name_category_armada')
                    ->label('Kategori Armada')
                    ->required()
                    ->preload()
                    ->searchable(),

                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name_customer')
                    ->label('Customer')
                    ->required(),

                Forms\Components\TextInput::make('name_car')
                    ->label('Nama Armada')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('plate_number')
                    ->label('Nomor Polisi')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('color')
                    ->label('Warna')
                    ->maxLength(255),

                Forms\Components\TextInput::make('year')
                    ->label('Tahun')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y')),
                
                Forms\Components\TextInput::make('frame_number')
                    ->label('Nomor Rangka')
                    ->maxLength(15),

                Forms\Components\TextInput::make('machine_number')
                    ->label('Nomor Mesin')
                    ->maxLength(15),

                Forms\Components\TextInput::make('driver')
                    ->label('Sopir')
                    ->maxLength(255),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'dalam_servis' => 'Dalam Servis',
                        'non_aktif' => 'Non-Aktif',
                    ])
                    ->default('aktif')
                    ->required(),

                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('categoryArmada.name_category_armada')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer.name_customer')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name_car')
                    ->label('Nama Armada')
                    ->searchable(),

                Tables\Columns\TextColumn::make('plate_number')
                    ->label('Nomor Polisi'),

                Tables\Columns\TextColumn::make('color')
                    ->label('Warna'),

                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),

                Tables\Columns\TextColumn::make('frame_number')
                    ->label('Nomor Rangka'),

                Tables\Columns\TextColumn::make('machine_number')
                    ->label('Nomor Mesin'),

                Tables\Columns\TextColumn::make('driver')
                    ->label('Sopir')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'aktif',
                        'warning' => 'dalam_servis',
                        'danger' => 'non_aktif',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'aktif' => 'Aktif',
                        'dalam_servis' => 'Dalam Servis',
                        'non_aktif' => 'Non-Aktif',
                        default => $state
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(30),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListArmadas::route('/'),
            'create' => Pages\CreateArmada::route('/create'),
            'edit' => Pages\EditArmada::route('/{record}/edit'),
        ];
    }
}
