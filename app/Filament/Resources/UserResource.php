<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    
    protected static ?string $navigationGroup = 'Pengaturan';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengguna')
                    ->description('Masukkan informasi detail pengguna')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Masukkan nama lengkap')
                                ->prefixIcon('heroicon-o-user'),
    
                            Forms\Components\TextInput::make('username')
                                ->label('Username')
                                ->required()
                                ->maxLength(50)
                                ->placeholder('Masukkan username unik')
                                ->unique(ignoreRecord: true)
                                ->prefixIcon('heroicon-o-identification'),
                        ]),
    
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->placeholder('email@example.com')
                                ->unique(ignoreRecord: true)
                                ->prefixIcon('heroicon-o-envelope'),
    
                            Forms\Components\TextInput::make('password')
                                ->label('Password')
                                ->password()
                                ->dehydrated(fn ($state) => filled($state))
                                ->required(fn (string $context): bool => $context === 'create')
                                ->maxLength(255)
                                ->placeholder(fn (string $context): string => $context === 'edit' ? '••••••••' : 'Masukkan password baru')
                                ->prefixIcon('heroicon-o-key')
                                ->helperText('Kosongkan jika tidak ingin mengganti password.'),
                        ]),
                    ]),
    
                Forms\Components\Section::make('Informasi Perusahaan')
                    ->description('Pilih perusahaan, departemen, dan posisi pengguna')
                    ->icon('heroicon-o-building-office')
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->label('Perusahaan')
                            ->relationship('company', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih perusahaan')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('department_id', null);
                                $set('position_id', null);
                            }),
    
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Select::make('department_id')
                                ->label('Departemen')
                                ->relationship('department', 'name', fn ($get, $query) =>
                                    $query->where('company_id', $get('company_id'))
                                )
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih departemen')
                                ->disabled(fn ($get) => !$get('company_id')),
    
                            Forms\Components\Select::make('position_id')
                                ->label('Posisi')
                                ->relationship('position', 'name', fn ($get, $query) =>
                                    $query->where('company_id', $get('company_id'))
                                )
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih posisi')
                                ->disabled(fn ($get) => !$get('company_id')),
                        ]),
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
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->weight('bold'),
    
                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-identification')
                    ->copyable(),
    
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-envelope')
                    ->copyable(),
    
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-building-office'),
    
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Departemen')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-building-library'),
    
                Tables\Columns\TextColumn::make('position.name')
                    ->label('Posisi')
                    ->badge()
                    ->color('success'),
    
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Email Terverifikasi')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
    
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}