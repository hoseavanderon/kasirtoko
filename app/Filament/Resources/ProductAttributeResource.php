<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductAttributeResource\Pages;
use App\Filament\Resources\ProductAttributeResource\RelationManagers;
use App\Models\ProductAttribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductAttributeResource extends Resource
{
    protected static ?string $model = ProductAttribute::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Product Attributes';
    protected static ?string $pluralLabel = 'Product Attributes';
    protected static ?string $modelLabel = 'Product Attribute';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_attribute')
                    ->label('Nama Attribute')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('data_type')
                    ->label('Data Type')
                    ->required()
                    ->options([
                        'string' => 'String',
                        'integer' => 'Integer',
                        'decimal' => 'Decimal',
                        'boolean' => 'Boolean',
                        'date' => 'Date',
                        'datetime' => 'Datetime',
                        'text' => 'Text',
                    ])
    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->rowIndex()
                    ->label('No'),

                Tables\Columns\TextColumn::make('nama_attribute')
                    ->label('Nama Attribute')
                    ->searchable(),

                Tables\Columns\TextColumn::make('data_type')
                    ->label('Data Type')
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
            'index' => Pages\ListProductAttributes::route('/'),
            'create' => Pages\CreateProductAttribute::route('/create'),
            'edit' => Pages\EditProductAttribute::route('/{record}/edit'),
        ];
    }
}
