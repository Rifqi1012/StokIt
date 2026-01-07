<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesChartWidget extends ChartWidget
{
    protected ?string $heading = 'Sales';

    protected int|string|array $columnSpan = 1;

    protected function getMaxHeight(): ?string
{
    return '240px';
}


    protected function getData(): array
    {
        $months = collect(range(4, 0))
            ->map(fn ($i) => now()->subMonths($i)->startOfMonth());

        $labels = $months->map(fn (Carbon $d) => strtoupper($d->format('M')))->toArray();

        $values = $months->map(function (Carbon $d) {
            return Sale::query()
                ->whereBetween('date', [$d->copy()->startOfMonth(), $d->copy()->endOfMonth()])
                ->count();
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
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
}
