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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('supplier')
                ->label('Nama Supplier')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('no_wa')
                ->label('Nomor WA')
                ->required()
                ->maxLength(20)
                ->tel()
                ->mutateDehydratedStateUsing(function ($state) {
                    // Hilangkan spasi dan strip
                    $number = preg_replace('/[^0-9]/', '', $state);

                    // Ubah 08xxx menjadi 62xxx
                    if (str_starts_with($number, '0')) {
                        $number = '62' . substr($number, 1);
                    }

                    return $number;
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nomor')
                ->label('No')
                ->state(static function ($record, \Filament\Tables\Columns\TextColumn $column, $rowLoop) {
                    return $rowLoop->iteration;
                }),

            Tables\Columns\TextColumn::make('supplier')->label('Supplier'),
            Tables\Columns\TextColumn::make('no_wa')->label('Nomor WA'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),

            Tables\Actions\Action::make('kirimWhatsApp')
                ->label('Kirim WA')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->url(fn ($record) => 'https://wa.me/' . $record->no_wa)
                ->openUrlInNewTab(),
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
