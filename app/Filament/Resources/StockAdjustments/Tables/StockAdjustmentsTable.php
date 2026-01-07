<?php

namespace App\Filament\Resources\StockAdjustments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;


class StockAdjustmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d M Y'),

                TextColumn::make('inventory.product')
                    ->label('Product')
                    ->searchable(),

                TextColumn::make('production_qty')
                    ->label('Total')
                    ->formatStateUsing(function ($state, $record) {
                        return $state . ' ' . ($record->unit?->name ?? '');
                    }),

                TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(30),

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
