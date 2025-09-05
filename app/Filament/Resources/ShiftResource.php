<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShiftResource\Pages;
use App\Models\Shift;
use App\Models\Karyawan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShiftResource extends Resource
{
    protected static ?string $model = Shift::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Karyawan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('karyawan_id')
                ->label('Karyawan')
                ->options(Karyawan::pluck('nama', 'id'))
                ->searchable()
                ->required(),
            DatePicker::make('tanggal')
                ->label('Tanggal')
                ->default(now())
                ->required(),
            TimePicker::make('jam_mulai')
                ->label('Jam Mulai')
                ->required(),
            TimePicker::make('jam_selesai')
                ->label('Jam Selesai')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('no')
                ->label('No')
                ->rowIndex(),

            Tables\Columns\TextColumn::make('karyawan.nama')
                ->label('Karyawan')
                ->searchable(),

            Tables\Columns\TextColumn::make('tanggal')
                ->label('Tanggal')
                ->formatStateUsing(fn () => '13 Agustus 2025'),

            Tables\Columns\TextColumn::make('jam_mulai')
                ->label('Jam Mulai'),

            Tables\Columns\TextColumn::make('jam_selesai')
                ->label('Jam Selesai'),
                ])
                ->defaultSort('tanggal', 'desc')
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
            'index' => Pages\ListShifts::route('/'),
            'create' => Pages\CreateShift::route('/create'),
            'edit' => Pages\EditShift::route('/{record}/edit'),
        ];
    }
}
