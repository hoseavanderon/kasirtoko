<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DigitalProductResource\Pages;
use App\Filament\Resources\DigitalProductResource\RelationManagers;
use App\Models\DigitalProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DigitalProductResource extends Resource
{
    protected static ?string $model = DigitalProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Digital Products';
    protected static ?string $pluralModelLabel = 'Digital Products';
    protected static ?string $modelLabel = 'Digital Product';
    protected static ?string $navigationGroup = 'Digital';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Pilih Category
                Forms\Components\Select::make('digital_category_id')
                    ->label('Digital Category')
                    ->relationship('category', 'nama')
                    ->searchable()
                    ->required(),

                // Nama Produk
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Product')
                    ->required()
                    ->maxLength(255),

                Forms\Components\CheckboxList::make('brands')
                    ->label('Digital Brands')
                    ->relationship('brands', 'nama') // tanpa schema()
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Product Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.nama')
                    ->label('Category'),

                Tables\Columns\TextColumn::make('brands.nama')
                    ->label('Brands')
                    ->formatStateUsing(fn ($state) => 
                        $state instanceof \Illuminate\Support\Collection
                            ? $state->pluck('nama')->implode(', ')
                            : (string) $state
                    )
                    ->limit(30),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDigitalProducts::route('/'),
            'create' => Pages\CreateDigitalProduct::route('/create'),
            'edit' => Pages\EditDigitalProduct::route('/{record}/edit'),
        ];
    }
}
