<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryCustomerResource\Pages;
use App\Filament\Resources\CategoryCustomerResource\RelationManagers;
use App\Models\CategoryCustomer;
use Filament\Forms;
use App\Filament\Clusters\MasterData;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryCustomerResource extends Resource
{
    protected static ?string $model = CategoryCustomer::class;
    protected static ?string $cluster = MasterData::class;
    public static function getNavigationGroup(): ?string
    {
        return 'Manage Customer';
    }
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Kategori Customer';
    protected static ?string $pluralModelLabel = 'Kategori Customer';
    protected static ?string $modelLabel = 'Kategori Customer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kategori')
                    ->description('Isi detail kategori customer dengan jelas.')
                    ->schema([
                        Forms\Components\TextInput::make('name_category_customer')
                            ->label('Nama Kategori')
                            ->required()
                            ->placeholder('Contoh: VIP, Premium, Regular')
                            ->prefixIcon('heroicon-o-tag')
                            ->helperText('Nama kategori unik untuk membedakan jenis customer.')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi (Opsional)')
                            ->rows(3)
                            ->placeholder('Tuliskan deskripsi singkat mengenai kategori ini...')
                            ->helperText('Contoh: Kategori VIP untuk pelanggan prioritas.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_category_customer')
                    ->label('Nama Kategori')
                    ->badge()
                    ->color(fn ($state) => match (strtolower($state)) {
                        'vip' => 'success',
                        'premium' => 'warning',
                        'regular' => 'info',
                        default => 'gray',
                    })
                    ->icon('heroicon-o-tag')
                    ->sortable()
                    ->searchable()
                    ->tooltip(fn ($record) => "Kategori: {$record->name_category_customer}"),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->wrap()
                    ->tooltip(fn ($record) => $record->description ?? '-'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // bisa ditambah filter kategori kalau perlu
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50])
            ->persistFiltersInSession();
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
            'index' => Pages\ListCategoryCustomers::route('/'),
            'create' => Pages\CreateCategoryCustomer::route('/create'),
            'edit' => Pages\EditCategoryCustomer::route('/{record}/edit'),
        ];
    }
}
