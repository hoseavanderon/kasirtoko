<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use App\Models\ProductAttribute;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;
use Carbon\Carbon;
use Filament\Forms\Components\Hidden;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_produk')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'nama')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (!$state) {
                            $set('barcode', null);
                            return;
                        }
                        $category = \App\Models\Category::find($state);
                        if (!$category) {
                            $set('barcode', null);
                            return;
                        }
                        $lastBarcode = \App\Models\Product::where('category_id', $state)
                            ->whereNotNull('barcode')
                            ->orderByDesc('barcode')
                            ->value('barcode');

                        if ($lastBarcode) {
                            $number = intval(substr($lastBarcode, strlen($category->kode_category))) + 1;
                        } else {
                            $number = 1;
                        }
                        $set('barcode', $category->kode_category . str_pad($number, 6, '0', STR_PAD_LEFT));
                    }),

                Forms\Components\Select::make('sub_category_id')
                    ->label('Sub Category')
                    ->relationship('subCategory', 'nama')
                    ->required(),

                Forms\Components\Select::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'nama')
                    ->required(),

                Forms\Components\TextInput::make('barcode')
                    ->label('Barcode')
                    ->disabled()
                    ->dehydrated(),

                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => Auth::id()),

                Forms\Components\TextInput::make('modal')
                    ->label('Modal')
                    ->required(),

                Forms\Components\TextInput::make('jual')
                    ->label('Harga Jual')
                    ->required(),

                Forms\Components\TextInput::make('minimal_stok')
                    ->label('Minimal Stok')
                    ->numeric()
                    ->default(0),

                Forms\Components\Select::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'supplier')
                    ->required(),

                Forms\Components\Select::make('shelf_id')
                    ->label('Shelf')
                    ->relationship('shelf', 'name') // relasi ke model Shelf
                    ->searchable()
                    ->preload()
                    ->required(),

                Repeater::make('attributeValues')
                    ->relationship('attributeValues')
                    ->schema([
                        Select::make('product_attribute_id')
                            ->label('Attribute')
                            ->options(fn () => ProductAttribute::pluck('nama_attribute', 'id'))
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('attribute_type', ProductAttribute::find($state)?->data_type)
                            )
                            ->required(),

                        Hidden::make('attribute_value')
                            ->dehydrateStateUsing(fn ($get) => match ($get('attribute_type')) {
                                'string' => $get('value_string'),
                                'integer' => $get('value_integer'),
                                'date' => $get('value_date'),
                                default => null,
                            }),

                        Hidden::make('attribute_type')
                            ->reactive()
                            // Ini adalah perbaikan utamanya
                            ->afterStateHydrated(fn ($state, callable $set, $record) =>
                                // Cek jika record dan relasi productAttribute ada sebelum diakses
                                $set('attribute_type', $record?->productAttribute?->data_type)
                            ),

                        TextInput::make('value_string')
                            ->label('Value')
                            ->visible(fn ($get) => $get('attribute_type') === 'string')
                            ->afterStateHydrated(fn (TextInput $component, $get, callable $set) =>
                                $set('value_string', $get('attribute_value'))
                            ),

                        TextInput::make('value_integer')
                            ->label('Value')
                            ->numeric()
                            ->visible(fn ($get) => $get('attribute_type') === 'integer')
                            ->afterStateHydrated(fn (TextInput $component, $get, callable $set) =>
                                $set('value_integer', $get('attribute_value'))
                            ),

                        DatePicker::make('value_date')
                            ->label('Value')
                            ->visible(fn ($get) => $get('attribute_type') === 'date')
                            ->afterStateHydrated(fn (DatePicker $component, $get, callable $set) =>
                                $set('value_date', $get('attribute_value'))
                            ),

                        TextInput::make('stok')
                            ->label('Stok')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        Hidden::make('last_restock_date')
                            ->default(fn () => now()->toDateString()),

                        Hidden::make('last_sale_date')
                            ->default(null),

                        Hidden::make('user_id')
                            ->default(fn () => Auth::id())
                            ->dehydrated(),
                    ])
                    ->label('Product Attributes')
                    ->columnSpanFull()
                    ->createItemButtonLabel('Tambah Attribute'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Nomor urut
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                // 2. Nama produk
                Tables\Columns\TextColumn::make('nama_produk')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                // 3. Barcode (gambar barcode)
                Tables\Columns\ImageColumn::make('barcode')
                    ->label('Barcode')
                    ->state(function ($record) {
                        // Generate barcode image (pakai package milon/barcode misalnya)
                        return 'data:image/png;base64,' . DNS1D::getBarcodePNG($record->barcode, 'C128', 2, 60);
                    })
                    ->extraImgAttributes(['class' => 'mx-auto']), // biar center

                // 4. Category
                Tables\Columns\TextColumn::make('category.nama')
                    ->label('Category')
                    ->sortable(),

                // 5. Modal
                Tables\Columns\TextColumn::make('modal')
                    ->label('Modal')
                    ->money('IDR', true), // otomatis format rupiah

                // 6. Harga Jual
                Tables\Columns\TextColumn::make('jual')
                    ->label('Harga Jual')
                    ->money('IDR', true),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
