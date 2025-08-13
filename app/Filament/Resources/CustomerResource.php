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
            Forms\Components\Select::make('category_customer_id')
                    ->relationship('categoryCustomer', 'name_category_customer')
                    ->label('Kategori Customer')
                    ->required()
                    ->preload(),
                Forms\Components\TextInput::make('name_customer')
                    ->label('Nama Customer')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('number')
                    ->label('No. Telepon')
                    ->tel(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email(),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat')
                    ->rows(3),
                Forms\Components\TextInput::make('npwp')
                    ->label('NPWP'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('categoryCustomer.name_category_customer')
                    ->label('Kategori Customer')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_customer')
                    ->label('Nama Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->label('No. Telepon'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(100),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
