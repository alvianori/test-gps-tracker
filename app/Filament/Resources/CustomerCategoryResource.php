<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerCategoryResource\Pages;
use App\Filament\Resources\CustomerCategoryResource\RelationManagers;
use App\Models\CustomerCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerCategoryResource extends Resource
{
    protected static ?string $model = CustomerCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kategori Pelanggan')
                    ->description('Masukkan informasi kategori pelanggan')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Kategori')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Contoh: Gold, Silver, Platinum')
                                ->unique(ignoreRecord: true)
                                ->prefixIcon('heroicon-o-tag')
                                ->helperText('Nama kategori pelanggan harus unik.'),
    
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
                            ->placeholder('Masukkan deskripsi kategori pelanggan')
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
                    ->color('success'),
    
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
                Components\Section::make('Detail Kategori Pelanggan')
                    ->schema([
                        Components\TextEntry::make('name')
                            ->label('Nama Kategori')
                            ->icon('heroicon-o-tag')
                            ->badge(),

                        Components\TextEntry::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Tidak ada deskripsi'),

                        Components\TextEntry::make('company.name')
                            ->label('Perusahaan')
                            ->badge()
                            ->color('success'),

                        Components\TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime('d M Y, H:i'),

                        Components\TextEntry::make('updated_at')
                            ->label('Diperbarui')
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
            'index' => Pages\ListCustomerCategories::route('/'),
            'create' => Pages\CreateCustomerCategory::route('/create'),
            'view' => Pages\ViewCustomerCategory::route('/{record}'),
            'edit' => Pages\EditCustomerCategory::route('/{record}/edit'),
        ];
    }
}