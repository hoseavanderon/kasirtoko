<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Kategori';

    protected static ?string $pluralModelLabel = 'Kategori';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')
                ->label('Nama Kategori')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('kode_category')
                ->label('Kode Kategori')
                ->required()
                ->maxLength(50),

            Forms\Components\HasManyRepeater::make('subCategories')
                ->relationship('subCategories')
                ->schema([
                    Forms\Components\TextInput::make('nama')
                        ->label('Sub Kategori')
                        ->required(),
                ])
                ->label('Sub Kategori')
                ->addActionLabel('Tambah Sub Kategori')
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nomor')
                ->label('No')
                ->state(
                    static function ($record, \Filament\Tables\Columns\TextColumn $column, $rowLoop) {
                        return $rowLoop->iteration;
                    }
                ),

            Tables\Columns\TextColumn::make('kode_category')
                ->label('Kode'),

            Tables\Columns\TextColumn::make('nama')
                ->label('Kategori'),
        ])
        ->filters([
            //
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
