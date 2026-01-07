<?php

namespace App\Filament\Widgets;

use App\Models\Inventory;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class InventoryOverviewWidget extends BaseWidget
{
    protected static ?string $heading = 'Inventory';


    protected int|string|array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Inventory::query()->with('category')->latest()->limit(4)
            )
            ->paginated(false)
            ->defaultPaginationPageOption(3)
            ->columns([
                Tables\Columns\TextColumn::make('product')
                    ->label('Product')
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(function (Inventory $record) {
                        $min = (int) ($record->category?->min_stock ?? 0);

                        if ((int) $record->stock <= 0) {
                            return 'Out of Stock';
                        }

                        if ((int) $record->stock <= $min) {
                            return 'Low';
                        }

                        return 'Good';
                    })
                    ->color(fn ($state) => match ($state) {
                        'Good' => 'success',
                        'Low' => 'warning',
                        'Out of Stock' => 'danger',
                        default => 'gray',
                    }),
            ]);
    }
}
