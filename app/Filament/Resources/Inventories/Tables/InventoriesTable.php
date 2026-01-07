<?php

namespace App\Filament\Resources\Inventories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class InventoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product')
                    ->label('Product')
                    ->searchable(),

                TextColumn::make('stock')
                    ->label('Stock'),

                TextColumn::make('price')
                    ->label('Purchase Price')
                    ->money('IDR', locale: 'id_ID'),

                TextColumn::make('selling_price')
                    ->label('Selling Price')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn(string $state) => match ($state) {
                        'good' => 'Good',
                        'low' => 'Low',
                        'out_of_stock' => 'Out of Stock',
                        default => $state,
                    })
                    ->color(fn(string $state) => match ($state) {
                        'good' => 'success',
                        'low' => 'warning',
                        'out_of_stock' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            ->recordActionsColumnLabel('Actions');
    }
}
