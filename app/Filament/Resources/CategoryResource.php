<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Produk';
    protected static ?string $label = 'Kategori & Sub Kategori';
    protected static ?string $navigationLabel = 'Kategory & Sub Kategori';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->required()
                ->label('Nama Kategori'),

            TextInput::make('kode_category')
                ->required()
                ->unique(ignoreRecord: true)
                ->label('Kode Kategori'),

            Repeater::make('subCategories')
                ->relationship()
                ->label('Sub Kategori')
                ->schema([
                    TextInput::make('nama')->required()->label('Nama Sub Kategori'),
                ])
                ->collapsible()
                ->defaultItems(1)
                ->createItemButtonLabel('Tambah Sub Kategori'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('no')
                ->label('No')
                ->rowIndex(),

            Tables\Columns\TextColumn::make('nama')
                ->label('Category')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('kode_category')
                ->label('Kode Category')
                ->sortable()
                ->searchable(),
            ])
                ->filters([])
                ->actions([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
