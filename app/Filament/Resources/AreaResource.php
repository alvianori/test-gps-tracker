<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AreaResource\Pages;
use App\Filament\Resources\AreaResource\RelationManagers;
use App\Models\Area;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AreaResource extends Resource
{
    protected static ?string $model = Area::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Area')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi'),

                Forms\Components\Select::make('companies_id')
                    ->label('Company')
                    ->relationship('company', 'name')
                    ->required(),

                Forms\Components\Select::make('users_id')
                    ->label('User PIC')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->nullable()
                    ->preload(),
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

                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('company.name')->label('Company'),
                Tables\Columns\TextColumn::make('user.name')->label('User PIC'),
                Tables\Columns\TextColumn::make('description')->limit(30),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->slideOver(),
                Tables\Actions\EditAction::make()->slideOver(),
                Tables\Actions\DeleteAction::make(),
            ]);
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Informasi Area')
                    ->schema([
                        Components\TextEntry::make('name')
                            ->label('Nama Area')
                            ->weight('bold')
                            ->icon('heroicon-o-map'),

                        Components\TextEntry::make('description')
                            ->label('Deskripsi')
                            ->placeholder('-'),
                    ])
                    ->columns(2),

                Components\Section::make('Relasi')
                    ->schema([
                        Components\TextEntry::make('company.name')
                            ->label('Perusahaan')
                            ->badge()
                            ->color('success'),

                        Components\TextEntry::make('user.name')
                            ->label('Penanggung Jawab')
                            ->badge()
                            ->color('info'),
                    ])
                    ->columns(2),

                Components\Section::make('Informasi Audit')
                    ->schema([
                        Components\TextEntry::make('create_by')
                            ->label('Dibuat Oleh'),

                        Components\TextEntry::make('update_by')
                            ->label('Diperbarui Oleh'),
                    ])
                    ->columns(2),

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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAreas::route('/'),
            'create' => Pages\CreateArea::route('/create'),
            'view' => Pages\ViewArea::route('/{record}'),
            'edit' => Pages\EditArea::route('/{record}/edit'),
        ];
    }
}
