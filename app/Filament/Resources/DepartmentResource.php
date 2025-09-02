<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Models\Department;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    protected static ?string $navigationGroup = 'Pengaturan';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Departemen')
                    ->description('Masukkan informasi detail departemen')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Departemen')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Contoh: Human Resource, Finance, IT Support')
                                ->unique(ignoreRecord: true)
                                ->prefixIcon('heroicon-o-academic-cap')
                                ->helperText('Nama departemen harus unik dalam perusahaan.'),
                            
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
                            ->placeholder('Masukkan deskripsi singkat mengenai fungsi departemen ini')
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
                    ->label('Nama Departemen')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-academic-cap')
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
                // contoh filter by perusahaan
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
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}