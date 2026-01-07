<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesRevenueChartWidget extends ChartWidget
{
    protected ?string $heading = 'SALE';

    protected function getData(): array
    {
        $months = collect(range(4, 0))
            ->map(fn ($i) => now()->subMonths($i)->startOfMonth());

        $labels = $months->map(fn (Carbon $d) => $d->format('M'))->toArray();

        $values = $months->map(function (Carbon $d) {
            return (int) Sale::query()
                ->whereBetween('date', [$d->copy()->startOfMonth(), $d->copy()->endOfMonth()])
                ->sum('total_price');
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Sale',
                    'data' => $values,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getMaxHeight(): ?string
    {
        return '260px';
    }
}
