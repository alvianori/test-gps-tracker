<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryArmadaResource\Pages;
use App\Models\CategoryArmada;
use App\Filament\Clusters\MasterData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

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

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Kategori Armada';
    protected static ?string $pluralModelLabel = 'Kategori Armada';
    protected static ?string $modelLabel = 'Kategori Armada';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kategori')
                    ->description('Isi detail kategori armada dengan lengkap.')
                    ->icon('heroicon-o-rectangle-stack')
                    ->collapsible()
                    ->schema([
                    TextInput::make('name_category_armada')
                        ->label('Nama Kategori Armada')
                        ->placeholder('Contoh: Bus Pariwisata')
                        ->required()
                        ->unique(ignoreRecord: true) // validasi biar gak duplikat
                        ->helperText('Masukkan nama kategori armada yang unik, misalnya "Bus Pariwisata" atau "Mobil Travel".')
                        ->columnSpanFull()
                        ->autofocus()
                        ->maxLength(255),

                    Textarea::make('description')
                        ->label('Deskripsi')
                        ->placeholder('Tuliskan deskripsi singkat mengenai kategori armada ini...')
                        ->rows(4)
                        ->columnSpanFull()
                        ->autosize()
                        ->helperText('Opsional, isi untuk memberikan detail tambahan mengenai kategori.'),
                                        ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_category_armada')
                    ->label('Nama Kategori Armada')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y H:i')
                    ->sortable()
                    ->icon('heroicon-o-calendar'), // 👉 kalau error, hapus koma ini
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Ubah')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus yang dipilih')
                        ->icon('heroicon-o-trash'),
                ]),
            ])
            ->striped()
            ->paginated([10, 25, 50]);
    }

    public static function getRelations(): array
    {
        return [];
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
