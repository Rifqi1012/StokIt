<?php

namespace App\Filament\Resources\Sales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class SalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inventory.product')
                    ->label('Order')
                    ->searchable(),

                TextColumn::make('customer')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('date')
                    ->label('Date')
                    ->date('d M Y'),

                TextColumn::make('channel.name')
                    ->label('Channel'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state === 'paid' ? 'Paid' : 'Unpaid')
                    ->color(fn($state) => $state === 'paid' ? 'success' : 'gray'),

                TextColumn::make('qty')
                    ->label('Quantity'),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format((int) $state, 0, ',', '.'))

            ])



            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->recordActionsColumnLabel('Actions');
            // ->toolbarActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //     ]),
            // ]);
    }
}
