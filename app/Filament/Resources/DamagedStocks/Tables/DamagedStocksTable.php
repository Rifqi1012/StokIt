<?php

namespace App\Filament\Resources\DamagedStocks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class DamagedStocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inventory.product')
                    ->label('Product')
                    ->searchable(),

                TextColumn::make('damaged_qty')
                    ->label('Jumlah Rusak'),

                TextColumn::make('reason')
                    ->label('Alasan')
                    ->searchable(),

                TextColumn::make('notes')
                    ->label('Catatan Kerusakan')
                    ->limit(30),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            ->recordActionsColumnLabel("Actions");
    }
}
