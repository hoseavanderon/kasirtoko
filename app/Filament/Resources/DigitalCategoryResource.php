<?php

namespace App\Filament\Resources;

use App\Models\DigitalCategory;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\DigitalCategoryResource\Pages;

class DigitalCategoryResource extends Resource
{
    protected static ?string $model = DigitalCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Digital Categories';
    protected static ?string $pluralModelLabel = 'Digital Categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('id')->label('No')->sortable(),
               TextColumn::make('name')->label('Nama Kategori')->searchable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDigitalCategories::route('/'),
            'create' => Pages\CreateDigitalCategory::route('/create'),
            'edit' => Pages\EditDigitalCategory::route('/{record}/edit'),
        ];
    }
}

