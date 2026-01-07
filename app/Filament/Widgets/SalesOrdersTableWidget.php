<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class SalesOrdersTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Pesanan';

    public string $statusFilter = 'all';

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('all')
                ->label('All')
                ->button()
                ->color($this->statusFilter === 'all' ? 'primary' : 'gray')
                ->action(fn() => $this->statusFilter = 'all'),

            \Filament\Actions\Action::make('paid')
                ->label('Paid')
                ->button()
                ->color($this->statusFilter === 'paid' ? 'primary' : 'gray')
                ->action(fn() => $this->statusFilter = 'paid'),

            \Filament\Actions\Action::make('unpaid')
                ->label('Unpaid')
                ->button()
                ->color($this->statusFilter === 'unpaid' ? 'primary' : 'gray')
                ->action(fn() => $this->statusFilter = 'unpaid'),

            \Filament\Actions\Action::make('all')
                ->label('All')
                ->button()
                ->extraAttributes(['class' => 'rounded-full px-6'])
                ->color($this->statusFilter === 'all' ? 'primary' : 'gray')
                ->action(fn() => $this->statusFilter = 'all'),

        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->defaultPaginationPageOption(10)
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order')
                    ->sortable(),

                Tables\Columns\TextColumn::make('customer')
                    ->label('Customer')
                    ->searchable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('M d')
                    ->sortable(),

                Tables\Columns\TextColumn::make('channel.name')
                    ->label('Channel'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => $state === 'paid' ? 'success' : 'warning'),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->alignEnd()
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format((int) $state, 0, ',', '.')),
            ]);
    }

    protected function getQuery()
    {
        return Sale::query()
            ->when($this->statusFilter !== 'all', function ($q) {
                $q->where('status', $this->statusFilter);
            })
            ->latest('date');
    }
}
