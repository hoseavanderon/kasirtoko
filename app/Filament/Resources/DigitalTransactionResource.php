<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DigitalTransactionResource\Pages;
use App\Filament\Resources\DigitalTransactionResource\RelationManagers;
use App\Models\DigitalTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DigitalTransactionResource extends Resource
{
    protected static ?string $model = DigitalTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Digital Transactions';
    protected static ?string $pluralModelLabel = 'Digital Transactions';
    protected static ?string $modelLabel = 'Digital Transaction';
    protected static ?string $navigationGroup = 'Digital';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('digital_product_id')
                    ->label('Digital Product')
                    ->relationship('digitalProduct', 'nama')
                    ->required(),

                Forms\Components\Select::make('digital_brand_id')
                    ->label('Digital Brand')
                    ->relationship('digitalBrand', 'nama')
                    ->required(),

                Forms\Components\TextInput::make('keterangan')
                    ->label('Keterangan'),

                Forms\Components\TextInput::make('harga_jual')
                    ->label('Harga Jual')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                Tables\Columns\TextColumn::make('product_brand')
                    ->label('Product + Brand')
                    ->getStateUsing(fn ($record) => $record->digitalProduct->nama . ' - ' . $record->digitalBrand->nama),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(30),

                Tables\Columns\TextColumn::make('harga_jual')
                    ->label('Harga Jual')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format((int) $state, 0, ',', '.')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d F Y'),
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
            'index' => Pages\ListDigitalTransactions::route('/'),
            'create' => Pages\CreateDigitalTransaction::route('/create'),
            'edit' => Pages\EditDigitalTransaction::route('/{record}/edit'),
        ];
    }
}
