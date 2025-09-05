<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DigitalCategoryResource\Pages;
use App\Filament\Resources\DigitalCategoryResource\RelationManagers;
use App\Models\DigitalCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DigitalCategoryResource extends Resource
{
    protected static ?string $model = DigitalCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Digital Categories';

    protected static ?string $pluralModelLabel = 'Digital Categories';
    protected static ?string $modelLabel = 'Digital Category';
    protected static ?string $navigationGroup = 'Digital';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Digital Category')
                    ->required()
                    ->maxLength(255),
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
                    ->label('Digital Category')
                    ->searchable(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
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
