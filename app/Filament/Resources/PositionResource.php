<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PositionResource\Pages;
use App\Models\Position;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    
    protected static ?string $navigationGroup = 'Pengaturan';
    
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Jabatan')
                    ->description('Masukkan informasi detail jabatan')
                    ->icon('heroicon-o-briefcase')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Jabatan')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Contoh: Manager, Staff, Supervisor')
                                ->unique(ignoreRecord: true)
                                ->prefixIcon('heroicon-o-briefcase')
                                ->helperText('Nama jabatan harus unik dalam perusahaan.'),
    
                            Forms\Components\Select::make('company_id')
                                ->label('Perusahaan')
                                ->relationship('company', 'name')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih perusahaan')
                                ->prefixIcon('heroicon-o-building-office'),
                        ]),
    
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->maxLength(1000)
                            ->placeholder('Masukkan deskripsi singkat mengenai jabatan ini')
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
                    ->label('Nama Jabatan')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-briefcase')
                    ->weight('bold')
                    ->copyable(),
    
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description),
    
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),
    
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
                Tables\Filters\SelectFilter::make('company_id')
                    ->label('Filter Perusahaan')
                    ->relationship('company', 'name')
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
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }
}