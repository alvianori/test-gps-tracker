<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\MasterData;
use App\Filament\Resources\ArmadaResource\Pages;
use App\Models\Armada;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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

    // ================== FORM ==================
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // === Bagian Informasi Armada ===
                Forms\Components\Section::make('Informasi Armada')
                    ->description('Data utama armada yang wajib diisi.')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Select::make('category_armada_id')
                                ->relationship('categoryArmada', 'name_category_armada')
                                ->label('Kategori Armada')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih kategori armada')
                                ->helperText('Contoh: Truk Box, Pick Up, Trailer'),

                            Forms\Components\Select::make('customer_id')
                                ->relationship('customer', 'name_customer')
                                ->label('Customer')
                                ->required()
                                ->searchable()
                                ->placeholder('Pilih customer terkait')
                                ->helperText('Armada ini digunakan oleh customer tertentu.'),
                        ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name_car')
                                ->label('Nama Armada')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Contoh: Truk Box A')
                                ->prefixIcon('heroicon-o-truck'),

                            Forms\Components\TextInput::make('plate_number')
                                ->label('Nomor Polisi')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->placeholder('Contoh: H 1234 AB')
                                ->prefixIcon('heroicon-o-identification'),
                        ]),
                    ]),

                // === Bagian Detail Kendaraan ===
                Forms\Components\Section::make('Detail Kendaraan')
                    ->description('Informasi detail kendaraan armada.')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('color')
                                ->label('Warna')
                                ->maxLength(255)
                                ->placeholder('Merah / Biru / Putih')
                                ->prefixIcon('heroicon-o-swatch'),

                            Forms\Components\TextInput::make('year')
                                ->label('Tahun')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue(date('Y'))
                                ->placeholder('2020')
                                ->helperText('Gunakan tahun pembuatan kendaraan.'),
                        ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('frame_number')
                                ->label('Nomor Rangka')
                                ->maxLength(30)
                                ->placeholder('Isi nomor rangka kendaraan')
                                ->prefixIcon('heroicon-o-hashtag'),

                            Forms\Components\TextInput::make('machine_number')
                                ->label('Nomor Mesin')
                                ->maxLength(30)
                                ->placeholder('Isi nomor mesin kendaraan')
                                ->prefixIcon('heroicon-o-cog-6-tooth'),
                        ]),
                    ]),

                // === Bagian Status & Lainnya ===
                Forms\Components\Section::make('Status & Lainnya')
                    ->description('Pengaturan status dan catatan tambahan.')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status Armada')
                            ->options([
                                'aktif' => 'Aktif',
                                'dalam_servis' => 'Dalam Servis',
                                'non_aktif' => 'Non-Aktif',
                            ])
                            ->default('aktif')
                            ->native(false)
                            ->required()
                            ->helperText('Pilih status armada saat ini.'),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan Tambahan (Opsional)')
                            ->placeholder('Tulis catatan atau informasi lain di sini...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    // ================== TABLE ==================
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('categoryArmada.name_category_armada')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-rectangle-stack')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer.name_customer')
                    ->label('Customer')
                    ->icon('heroicon-o-user')
                    ->sortable()
                    ->searchable()
                    ->tooltip(fn ($record) => "Customer: {$record->customer->name_customer}"),

                Tables\Columns\TextColumn::make('name_car')
                    ->label('Nama Armada')
                    ->weight('bold')
                    ->icon('heroicon-o-truck')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('plate_number')
                    ->label('Nomor Polisi')
                    ->copyable()
                    ->copyMessage('Nomor polisi berhasil disalin!')
                    ->icon('heroicon-o-identification')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'aktif',
                        'warning' => 'dalam_servis',
                        'danger'  => 'non_aktif',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'aktif' => 'Aktif',
                        'dalam_servis' => 'Dalam Servis',
                        'non_aktif' => 'Non-Aktif',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('color')
                    ->label('Warna')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('frame_number')
                    ->label('Nomor Rangka')
                    ->limit(20)
                    ->tooltip(fn ($record) => $record->frame_number)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('machine_number')
                    ->label('Nomor Mesin')
                    ->limit(20)
                    ->tooltip(fn ($record) => $record->machine_number)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'dalam_servis' => 'Dalam Servis',
                        'non_aktif' => 'Non-Aktif',
                    ])
                    ->default('aktif')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->color('info'),
                Tables\Actions\EditAction::make()->color('warning'),
                Tables\Actions\DeleteAction::make()->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50, 100])
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [];
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
