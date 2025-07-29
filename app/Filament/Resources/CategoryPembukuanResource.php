<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryPembukuanResource\Pages;
use App\Filament\Resources\CategoryPembukuanResource\RelationManagers;
use App\Models\CategoryPembukuan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryPembukuanResource extends Resource
{
    protected static ?string $model = CategoryPembukuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Kategori Pembukuan';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?string $pluralLabel = 'Kategori Pembukuan';
    protected static ?string $modelLabel = 'Kategori Pembukuan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('category_pembukuan')
                ->label('Nama Kategori')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->rowIndex() // Menampilkan nomor urut baris, bukan ID
                    ->sortable(),

                TextColumn::make('category_pembukuan')
                    ->label('Nama Kategori')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategoryPembukuans::route('/'),
            'create' => Pages\CreateCategoryPembukuan::route('/create'),
            'edit' => Pages\EditCategoryPembukuan::route('/{record}/edit'),
        ];
    }
}