<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Customers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('customer_name')
                    ->label('Nama Customer')
                    ->required()
                    ->maxLength(255),

                Section::make('Atribut Customer')
                    ->schema([
                        Repeater::make('attributes') // harus sesuai nama relasi di model Customer
                            ->relationship('attributes')
                            ->schema([
                                TextInput::make('attribute')
                                    ->label('Atribut')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('attribute_value')
                                    ->label('Nomer nya')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('attribute_notes')
                                    ->label('Catatan')
                                    ->rows(2)
                                    ->maxLength(500)
                                    ->nullable(),
                            ])
                            ->collapsible()
                            ->columns(1)
                            ->createItemButtonLabel('Tambah Atribut'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama Customer')
                    ->sortable()
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
