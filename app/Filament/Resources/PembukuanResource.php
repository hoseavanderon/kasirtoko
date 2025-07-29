<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembukuanResource\Pages;
use App\Filament\Resources\PembukuanResource\RelationManagers;
use App\Models\Pembukuan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembukuanResource extends Resource
{
    protected static ?string $model = Pembukuan::class;
    protected static ?string $navigationLabel = 'Pembukuan';
    protected static ?string $pluralLabel = 'Pembukuan';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->rows(2)
                ->required(),

            Forms\Components\Select::make('type')
                ->label('Tipe')
                ->required()
                ->options([
                    'IN' => 'IN',
                    'OUT' => 'OUT',
                ]),

            Forms\Components\TextInput::make('nominal')
                ->label('Nominal')
                ->required()
                ->numeric(),

            Forms\Components\Select::make('category_pembukuan_id')
                ->label('Kategori Pembukuan')
                ->relationship('categoryPembukuan', 'category_pembukuan')
                ->required(),

            Forms\Components\Hidden::make('sisa_saldo')
                ->dehydrated(true),

            Forms\Components\Hidden::make('user_id')
                ->default(fn () => Auth::id())
                ->dehydrated(true),
        ])
        ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Keterangan')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('IN / OUT')
                    ->badge()
                    ->color(fn ($state) => $state === 'IN' ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('nominal')
                    ->label('Nominal')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                Tables\Columns\TextColumn::make('categoryPembukuan.category_pembukuan')
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('sisa_saldo')
                    ->label('Saldo')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d-m-Y'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembukuans::route('/'),
            'create' => Pages\CreatePembukuan::route('/create'),
            'edit' => Pages\EditPembukuan::route('/{record}/edit'),
        ];
    }
}
