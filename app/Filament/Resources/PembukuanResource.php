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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembukuanResource extends Resource
{
    protected static ?string $model = Pembukuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Pembukuan';
    protected static ?string $navigationLabel = 'Pembukuan';
    protected static ?string $pluralModelLabel = 'Pembukuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('deskripsi')
                    ->label('Deskripsi')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('type')
                    ->label('Tipe')
                    ->options([
                        'IN' => 'Pemasukan',
                        'OUT' => 'Pengeluaran',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('nominal')
                    ->label('Nominal')
                    ->numeric()
                    ->required(),

                Forms\Components\Select::make('category_pembukuan_id')
                    ->label('Kategori Pembukuan')
                    ->relationship('categoryPembukuan', 'category_pembukuan')
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
                    
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipe')
                    ->colors([
                        'success' => 'IN',
                        'danger' => 'OUT',
                    ]),

                Tables\Columns\TextColumn::make('nominal')
                    ->label('Nominal')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('categoryPembukuan.category_pembukuan')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([

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
            'index' => Pages\ListPembukuans::route('/'),
            'create' => Pages\CreatePembukuan::route('/create'),
            'edit' => Pages\EditPembukuan::route('/{record}/edit'),
        ];
    }
}
