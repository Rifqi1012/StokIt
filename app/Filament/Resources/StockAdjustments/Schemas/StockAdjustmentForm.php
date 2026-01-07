<?php

namespace App\Filament\Resources\StockAdjustments\Schemas;

use Filament\Schemas\Schema;
use App\Models\Inventory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class StockAdjustmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Select::make('inventory_id')
                    ->label('Product')
                    ->relationship('inventory', 'product')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        $stock = (int) \App\Models\Inventory::whereKey($state)->value('stock');
                        $set('available_stock', $stock);
                    }),

                TextInput::make('available_stock')
                    ->label('Available Stock')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->required(),

                Select::make('unit_id')
                    ->label('Unit')
                    ->relationship('unit', 'name')
                    ->required(),

                TextInput::make('production_qty')
                    ->label('Production Qty')
                    ->numeric()
                    ->minValue(1)
                    ->required(),

                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(4)

            ]);
    }
}
