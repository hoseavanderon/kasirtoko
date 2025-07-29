<?php

namespace App\Filament\Resources;

use App\Models\Product;
use App\Models\ProductAttribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\ProductResource\Pages;
use Filament\Tables\Columns\ImageColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama_produk')->required(),

            TextInput::make('barcode')
                ->disabled()
                ->default(fn () => 'OTOMATIS')
                ->dehydrated(false),

            Select::make('category_id')
                ->relationship('kategori', 'nama')
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set) => $set('barcode', null)),

            Select::make('sub_category_id')
                ->relationship('subKategori', 'nama')
                ->required(),

            Select::make('brand_id')
                ->relationship('brand', 'nama')
                ->required(),

            TextInput::make('modal')
                ->numeric()
                ->prefix('Rp ')
                ->required(),

            TextInput::make('jual')
                ->numeric()
                ->prefix('Rp ')
                ->required(),

            TextInput::make('minimal_stok')
                ->numeric()
                ->label('Minimal Stok')
                ->required(),

            Repeater::make('attributeValues')
                ->relationship()
                ->schema([

                    Forms\Components\Select::make('attribute_id')
                        ->label('Attribute')
                        ->options(fn () => \App\Models\ProductAttribute::pluck('nama_attribute', 'id'))
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set) => 
                            $set('attribute_type', \App\Models\ProductAttribute::find($state)?->data_type)
                        )
                        ->required(),

                    Forms\Components\Hidden::make('attribute_type'),

                    Forms\Components\Group::make([
                        TextInput::make('attribute_value')
                            ->label('Value')
                            ->visible(fn ($get) => $get('attribute_type') === 'string'),

                        TextInput::make('attribute_value')
                            ->label('Value')
                            ->numeric()
                            ->visible(fn ($get) => $get('attribute_type') === 'number'),

                        DatePicker::make('attribute_value')
                            ->label('Value')
                            ->visible(fn ($get) => $get('attribute_type') === 'date'),
                    ]),

                    TextInput::make('stok')
                        ->label('Stok')
                        ->numeric()
                        ->required(),
                        
                    Hidden::make('last_restock_date')
                        ->default(now()->toDateString())
                        ->dehydrated(),

                    Hidden::make('last_sale_date')
                        ->default(now()->toDateString())
                        ->dehydrated(),
                ])
                ->label('Product Attributes')
                ->columnSpan('full')
                ->createItemButtonLabel('Tambah Attribute'),

            Hidden::make('user_id')
                ->default(fn () => Auth::id())
                ->dehydrated()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('No.')
                    ->rowIndex()
                    ->sortable(),
                
                ImageColumn::make('barcode_image')
                    ->label('Barcode')
                    ->height(60)
                    ->width(240)
                    ->extraImgAttributes([
                        'style' => 'background-color: white; padding: 4px; border-radius: 4px;',
                    ]),

                TextColumn::make('nama_produk')
                    ->label('Nama Produk')
                    ->searchable(),

                TextColumn::make('modal')
                    ->label('Modal')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                TextColumn::make('jual')
                    ->label('Harga Jual')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                TextColumn::make('total_stok')
                    ->label('Stok')
                    ->formatStateUsing(fn ($state) => $state . ' pcs'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
