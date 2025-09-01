<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    
    protected static ?string $navigationGroup = 'Pengaturan';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Perusahaan')
                    ->description('Masukkan informasi detail perusahaan dengan benar')
                    ->icon('heroicon-o-building-office-2')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Perusahaan')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Masukkan nama perusahaan')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $state, callable $set) {
                                    $set('slug', str()->slug($state));
                                })
                                ->helperText('Nama perusahaan akan digunakan untuk slug otomatis.'),
    
                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->maxLength(255)
                                ->disabled()
                                ->dehydrated()
                                ->unique(ignoreRecord: true),
                        ]),
    
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->maxLength(255)
                                ->placeholder('email@perusahaan.com')
                                ->prefixIcon('heroicon-o-envelope'),
    
                            Forms\Components\TextInput::make('phone')
                                ->label('Nomor Telepon')
                                ->tel()
                                ->required()
                                ->maxLength(20)
                                ->placeholder('8123456789')
                                ->prefix('+62')
                                ->regex('/^[0-9]{9,15}$/')
                                ->helperText('Nomor telepon hanya angka, tanpa spasi atau simbol lain.')
                                ->validationAttribute('nomor telepon')
                                ->prefixIcon('heroicon-o-phone'),
                        ]),
    
                        Forms\Components\Select::make('business_type_id')
                            ->label('Jenis Bisnis')
                            ->relationship('businessType', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih jenis bisnis'),
                    ]),
    
                Forms\Components\Section::make('Informasi Alamat & NPWP')
                    ->description('Masukkan alamat lengkap dan NPWP perusahaan')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->required()
                            ->maxLength(1000)
                            ->placeholder('Masukkan alamat lengkap perusahaan')
                            ->rows(3)
                            ->columnSpanFull(),
    
                        Forms\Components\TextInput::make('npwp')
                            ->label('NPWP')
                            ->maxLength(20)
                            ->placeholder('99.999.999.9-999.999')
                            ->mask('99.999.999.9-999.999')
                            ->prefixIcon('heroicon-o-document-text')
                            ->helperText('Format: 99.999.999.9-999.999'),
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
                    ->label('Nama Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-building-office-2')
                    ->weight('bold'),
    
                Tables\Columns\TextColumn::make('businessType.name')
                    ->label('Jenis Bisnis')
                    ->badge()
                    ->color('success')
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-o-envelope')
                    ->copyable(),
    
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->icon('heroicon-o-phone')
                    ->copyable(),
    
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->address)
                    ->icon('heroicon-o-map-pin'),
    
                Tables\Columns\TextColumn::make('npwp')
                    ->label('NPWP')
                    ->searchable()
                    ->icon('heroicon-o-document-text')
                    ->copyable(),
    
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'view' => Pages\ViewCompany::route('/{record}'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
