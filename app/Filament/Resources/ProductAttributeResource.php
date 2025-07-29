<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductAttributeResource\Pages;
use App\Models\ProductAttribute;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductAttributeResource extends Resource
{
    protected static ?string $model = ProductAttribute::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Produk';
    protected static ?string $modelLabel = 'Atribut Produk';
    protected static ?string $pluralModelLabel = 'Atribut Produk';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_attribute')
                ->label('Nama Atribut')
                ->required()
                ->maxLength(100),

            Forms\Components\Select::make('data_type')
                ->label('Tipe Data')
                ->options([
                    'string' => 'String (Teks)',
                    'integer' => 'Integer (Angka)',
                    'float' => 'Float (Desimal)',
                    'boolean' => 'Boolean (Ya/Tidak)',
                    'date' => 'Date (Tanggal)',
                    'datetime' => 'DateTime (Tanggal & Waktu)',
                ])
                ->nullable()
                ->searchable()
                ->helperText('Jenis data yang akan disimpan di atribut ini.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex(),

                Tables\Columns\TextColumn::make('nama_attribute')
                    ->label('Nama Atribut')
                    ->searchable(),

                Tables\Columns\TextColumn::make('data_type')
                    ->label('Tipe Data')
                    ->sortable(),
            ])
            ->filters([]) // tidak pakai filter
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
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
