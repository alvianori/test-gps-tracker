<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use App\Filament\Clusters\MasterData;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $cluster = MasterData::class;
    public static function getNavigationGroup(): ?string
    {
        return 'Manage Customer';
    }
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Customer';
    protected static ?string $pluralModelLabel = 'Customer';
    protected static ?string $modelLabel = 'Customer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Customer')
                    ->description('Isi informasi data customer dengan lengkap.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('category_customer_id')
                                    ->relationship('categoryCustomer', 'name_category_customer')
                                    ->label('Kategori Customer')
                                    ->required()
                                    ->placeholder('Pilih kategori customer...')
                                    ->searchable()
                                    ->preload()
                                    ->helperText('Contoh: VIP, Premium, atau Regular'),

                                Forms\Components\TextInput::make('name_customer')
                                    ->label('Nama Customer')
                                    ->required()
                                    ->placeholder('Masukkan nama lengkap customer')
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-user'),

                                Forms\Components\TextInput::make('number')
                                    ->label('No. Telepon')
                                    ->tel()
                                    ->required()
                                    ->prefix('+62') // otomatis tampil +62 di depan input
                                    ->placeholder('81234567890') // user tinggal isi tanpa 0 di depan
                                    ->helperText('Nomor telepon tanpa 0 di depan. Contoh: 81234567890'),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->placeholder('contoh@email.com')
                                    ->prefixIcon('heroicon-o-envelope')
                                    ->helperText('Pastikan email valid'),
                            ]),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Detail Lanjutan')
                    ->description('Opsional: isi bila diperlukan.')
                    ->collapsible()
                    ->collapsed() // default tertutup biar simple
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->placeholder('Tulis alamat lengkap customer di sini...')
                            ->columnSpanFull()
                            ->helperText('Isi alamat sesuai KTP atau domisili'),

                        Forms\Components\TextInput::make('npwp')
                            ->label('NPWP (Opsional)')
                            ->maxLength(30)
                            ->placeholder('XX.XXX.XXX.X-XXX.XXX')
                            ->prefixIcon('heroicon-o-document-text'),
                    ]),
            ]);
    }

        public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('categoryCustomer.name_category_customer')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'VIP' => 'success',
                        'Premium' => 'warning',
                        'Regular' => 'info',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name_customer')
                    ->label('Nama Customer')
                    ->icon('heroicon-o-user')
                    ->weight('bold')
                    ->sortable()
                    ->searchable()
                    ->tooltip(fn ($record) => "Customer: {$record->name_customer}"),

                Tables\Columns\TextColumn::make('number')
                    ->label('Telepon')
                    ->icon('heroicon-o-phone')
                    ->copyable()
                    ->copyMessage('Nomor telepon berhasil disalin!')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Email berhasil disalin!')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->address)
                    ->wrap()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_customer_id')
                    ->relationship('categoryCustomer', 'name_category_customer')
                    ->label('Filter Kategori')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->color('info'),

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
            ->striped() // buat zebra style
            ->defaultSort('created_at', 'desc') // urutkan terbaru di atas
            ->paginated([10, 25, 50, 100]) // pilihan jumlah row
            ->persistFiltersInSession(); // simpan filter user biar gak reset
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
