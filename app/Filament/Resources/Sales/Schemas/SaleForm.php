<?php

namespace App\Filament\Resources\Sales\Schemas;

use App\Models\Inventory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SaleForm
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
                    ->disabled(fn (string $operation) => $operation === 'edit')
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $qty = (int) ($get('qty') ?: 0);

                        $inventory = Inventory::query()
                            ->select(['id', 'stock', 'selling_price'])
                            ->whereKey($state)
                            ->first();

                        $stock = (int) ($inventory?->stock ?? 0);
                        $price = (int) ($inventory?->selling_price ?? 0);

                        // tampilkan stock tersedia
                        $set('available_stock', $stock);

                        // kalau qty kebesaran, cap qty ke stock
                        if ($stock > 0 && $qty > $stock) {
                            $qty = $stock;
                            $set('qty', $qty);
                        }
                        $total = $qty * $price;
                        $set('total_price', number_format($total, 0, ',', '.'));
                    }),

                TextInput::make('available_stock')
                    ->label('Stock Available')
                    ->disabled()
                    ->dehydrated(false)
                    ->default('0'),

                TextInput::make('qty')
                    ->label('Qty')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required()
                    ->live()
                    ->disabled(fn (string $operation) => $operation === 'edit')
                    ->helperText('Qty tidak boleh melebihi stock tersedia.')
                    ->rule(function ($get) {
                        return function (string $attribute, $value, \Closure $fail) use ($get) {
                            $inventoryId = $get('inventory_id');

                            if (! $inventoryId) {
                                return;
                            }

                            $stock = (int) Inventory::query()->whereKey($inventoryId)->value('stock');
                            $qty = (int) $value;

                            if ($qty > $stock) {
                                $fail("Stock tidak mencukupi. Stock tersedia: {$stock}.");
                            }
                        };
                    })
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $inventoryId = $get('inventory_id');

                        $inventory = Inventory::query()
                            ->select(['stock', 'selling_price'])
                            ->whereKey($inventoryId)
                            ->first();

                        $stock = (int) ($inventory?->stock ?? 0);
                        $price = (int) ($inventory?->selling_price ?? 0);

                        $set('available_stock', $stock);

                        $qty = (int) $state;

                        if ($stock > 0 && $qty > $stock) {
                            $qty = $stock;
                            $set('qty', $qty);
                        }
                        $total = $qty * $price;
                        $set('total_price', number_format($total, 0, ',', '.'));
                    }),

                TextInput::make('total_price')
                    ->label('Total Price')
                    ->prefix('Rp')
                    ->disabled()
                    ->required()
                    ->dehydrated()
                    ->dehydrateStateUsing(fn ($state) => (int) preg_replace('/\D+/', '', (string) $state)),

                TextInput::make('customer')
                    ->label('Customer')
                    ->maxLength(255)
                    ->disabled(fn (string $operation) => $operation === 'edit'),

                DatePicker::make('date')
                    ->label('Date')
                    ->required()
                    ->default(now())
                    ->disabled(fn (string $operation) => $operation === 'edit'),

                Select::make('channel_id')
                    ->label('Channel')
                    ->relationship('channel', 'name')
                    ->searchable()
                    ->preload()
                    ->disabled(fn (string $operation) => $operation === 'edit'),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'paid' => 'Paid',
                        'unpaid' => 'Unpaid',
                    ])
                    ->default('paid')
                    ->required(),
            ]);
    }
}
