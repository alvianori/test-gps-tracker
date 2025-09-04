<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicePackageResource\Pages;
use App\Models\ServicePackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;

class ServicePackageResource extends Resource
{
    protected static ?string $model = ServicePackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Paket')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Paket')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(string $state, callable $set) => 
                                    $set('slug', str()->slug($state))
                                ),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->disabled()
                                ->dehydrated()
                                ->unique(ignoreRecord: true),
                        ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('price')
                                ->label('Harga')
                                ->numeric()
                                ->prefix('Rp')
                                ->required(),

                            Forms\Components\Toggle::make('status')
                                ->label('Aktif')
                                ->default(true),
                        ]),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Fitur Paket')
                    ->schema([
                        Forms\Components\Select::make('features')
                            ->label('Fitur')
                            ->relationship('features', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->placeholder('Pilih fitur untuk paket ini'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rowIndex')
                    ->label('No')
                    ->rowIndex(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Paket')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('idr'),

                Tables\Columns\TextColumn::make('features.name')
                    ->label('Fitur')
                    ->badge()
                    ->separator(', '),

                Tables\Columns\BooleanColumn::make('status')
                    ->label('Aktif'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y, H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                // Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                // ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Informasi Paket')
                    ->schema([
                        Components\TextEntry::make('name')
                            ->label('Nama Paket')
                            ->weight('bold'),

                        Components\TextEntry::make('slug')
                            ->label('Slug')
                            ->copyable(),

                        Components\TextEntry::make('price')
                            ->label('Harga')
                            ->money('idr'),

                        Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn($state) => $state ? 'success' : 'danger'),
                    ])
                    ->columns(2),

                Components\Section::make('Deskripsi')
                    ->schema([
                        Components\TextEntry::make('description')
                            ->label('Deskripsi Paket'),
                    ]),

                Components\Section::make('Fitur Paket')
                    ->schema([
                        Components\TextEntry::make('features.name')
                            ->label('Fitur')
                            ->badge()
                            ->separator(', '),
                    ]),

                Components\Section::make('Informasi Waktu')
                    ->schema([
                        Components\TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d M Y, H:i'),

                        Components\TextEntry::make('updated_at')
                            ->label('Diperbarui Pada')
                            ->dateTime('d M Y, H:i'),
                    ])
                    ->columns(2),
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
            'view' => Pages\ViewServicePackage::route('/{record}'),
            'edit' => Pages\EditServicePackage::route('/{record}/edit'),
        ];
    }
}
