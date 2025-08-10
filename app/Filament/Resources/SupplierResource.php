<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Produk';
    protected static ?string $label = 'Supplier';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('supplier')
                ->label('Nama Supplier')
                ->required(),

            Forms\Components\TextInput::make('no_wa')
                ->label('Nomor WhatsApp')
                ->required()
                ->tel()
                ->maxLength(20)
                ->dehydrateStateUsing(function ($state) {
                    return preg_replace('/^0/', '62', $state);
                })
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('no')
                ->label('No')
                ->rowIndex(),

            Tables\Columns\TextColumn::make('supplier')
                ->label('Nama Supplier')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('no_wa')
                ->label('No WA')
                ->sortable()
                ->searchable(),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
