<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTransactionsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Transactions';

    protected int|string|array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(Sale::query()->latest('date'))
            ->paginated(false)
            ->defaultPaginationPageOption(3)
            ->columns([
                Tables\Columns\TextColumn::make('customer')
                    ->label('Customer')
                    ->searchable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('M d'),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->alignEnd()
                    ->formatStateUsing(fn ($state) => 'Rp. ' . number_format((int) $state, 0, ',', '.')),
            ]);
    }
}
