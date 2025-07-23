<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DigitalTransactionResource\Pages;
use App\Models\DigitalTransaction;
use App\Models\DigitalProduct;
use App\Models\DigitalBrand;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Support\Facades\Auth;

class DigitalTransactionResource extends Resource
{
    protected static ?string $model = DigitalTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Transaksi Digital';
    protected static ?string $pluralModelLabel = 'Transaksi Digital';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            BelongsToSelect::make('digital_product_id')
                ->label('Produk Digital')
                ->relationship('digitalProduct', 'name')
                ->preload() // agar langsung tampil semua data
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set, callable $get) => self::generateKeterangan($set, $get)),

            BelongsToSelect::make('brand_id')
                ->label('Brand')
                ->relationship('brand', 'name')
                ->preload()
                ->searchable()
                ->nullable()
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set, callable $get) => self::generateKeterangan($set, $get)),

            Textarea::make('keterangan')
                ->label('Keterangan')
                ->disabled()
                ->dehydrated()
                ->rows(2)
                ->maxLength(255),

            TextInput::make('harga_jual')
                ->label('Harga Jual')
                ->required()
                ->numeric()
                ->prefix('Rp'),

            DateTimePicker::make('transaction_date')
                ->default(now())
                ->visible(false)
                ->dehydrated(),

            Forms\Components\Hidden::make('user_id')
                ->default(fn () => Auth::id())
                ->dehydrated(),
        ])
        ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('id')
                    ->label('No.')
                    ->rowIndex(),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->getStateUsing(function ($record) {
                        $produk = $record->digitalProduct?->name ?? '';
                        $brand = $record->brand?->name ?? '';
                        return trim("{$produk} {$brand}");
                    }),

                TextColumn::make('harga_jual')
                    ->label('Bayar')
                    ->money('IDR'),

                TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->getStateUsing(fn ($record) => \Carbon\Carbon::parse($record->transaction_date)->translatedFormat('d F Y')),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['transaction_date'] = now(); // jika kamu ingin pastikan ini juga

        return $data;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDigitalTransactions::route('/'),
            'create' => Pages\CreateDigitalTransaction::route('/create'),
            'edit' => Pages\EditDigitalTransaction::route('/{record}/edit'),
        ];
    }

    protected static function generateKeterangan(callable $set, callable $get): void
    {
        $digitalProduct = \App\Models\DigitalProduct::find($get('digital_product_id'));
        $brand = \App\Models\DigitalBrand::find($get('brand_id'));

        $namaProduk = $digitalProduct?->name ?? '';
        $nominal = $digitalProduct?->nominal ? ' ' . number_format($digitalProduct->nominal, 0, ',', '.') : '';
        $namaBrand = $brand?->name ? ' ' . $brand->name : '';

        $keterangan = trim($namaProduk . $nominal . $namaBrand);
        $set('keterangan', $keterangan);
    }
}
