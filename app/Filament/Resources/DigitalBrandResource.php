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
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DigitalBrandResource extends Resource
{
    protected static ?string $model = DigitalBrand::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Brand')
                    ->required()
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor')
                ->label('No')
                ->state(static function ($record, \Filament\Tables\Columns\TextColumn $column, $rowLoop) {
                    return $rowLoop->iteration;
                }),
                Tables\Columns\TextColumn::make('name')->label('Nama Brand')->searchable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
