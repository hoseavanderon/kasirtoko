<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DigitalProductResource\Pages;
use App\Models\DigitalProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Columns\TextColumn;

class DigitalProductResource extends Resource
{
    protected static ?string $model = DigitalProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationLabel = 'Digital Product';
    protected static ?string $modelLabel = 'Digital Product';
    protected static ?string $pluralModelLabel = 'Digital Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('digital_category_id')
                    ->label('Kategori')
                    ->relationship('digitalCategory', 'name')
                    ->required(),

                TextInput::make('name')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(255),

                CheckboxList::make('digitalBrands')
                    ->label('Brands')
                    ->relationship('digitalBrands', 'name')
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('digitalCategory.name')->label('Kategori'),
                TextColumn::make('name')->label('Nama Produk'),
                TextColumn::make('digitalBrands.name')
                    ->label('Brand')
                    ->separator(', ')
                    ->limit(30),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDigitalProducts::route('/'),
            'create' => Pages\CreateDigitalProduct::route('/create'),
            'edit' => Pages\EditDigitalProduct::route('/{record}/edit'),
        ];
    }
}
