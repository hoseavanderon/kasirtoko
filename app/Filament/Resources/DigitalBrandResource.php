<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DigitalBrandResource\Pages;
use App\Filament\Resources\DigitalBrandResource\RelationManagers;
use App\Models\DigitalBrand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DigitalBrandResource extends Resource
{
    protected static ?string $model = DigitalBrand::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Digital Brands';

    protected static ?string $pluralModelLabel = 'Digital Brands';
    protected static ?string $modelLabel = 'Digital Brand';
    protected static ?string $navigationGroup = 'Digital';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Digital Brand')
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
                    ->label('Digital Brand')
                    ->searchable(),
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
            'index' => Pages\ListDigitalBrands::route('/'),
            'create' => Pages\CreateDigitalBrand::route('/create'),
            'edit' => Pages\EditDigitalBrand::route('/{record}/edit'),
        ];
    }
}
