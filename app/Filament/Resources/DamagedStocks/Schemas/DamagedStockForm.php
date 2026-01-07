<?php

namespace App\Filament\Resources\DamagedStocks\Schemas;

use Filament\Schemas\Schema;
use App\Models\Inventory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class DamagedStockForm
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
                        $stock = (int) Inventory::query()->whereKey($state)->value('stock');
                        $set('available_stock', $stock);
                    })
                    ->disabled(fn(string $operation) => $operation === 'edit'),

                TextInput::make('available_stock')
                    ->label('Available Stock')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->required(),

                TextInput::make('damaged_qty')
                    ->label('Damaged Qty')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->disabled(fn(string $operation) => $operation === 'edit'),

                TextInput::make('reason')
                    ->label('Reason')
                    ->maxLength(255),

                Textarea::make('notes')
                    ->label('Damage Notes')
                    ->rows(4)
                    ->maxLength(2000),
            ]);
    }
}
