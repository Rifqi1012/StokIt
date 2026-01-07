<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\Widget;

class SalesStatsWidget extends Widget
{
    protected string $view = 'filament.widgets.sales-stats-widget';

    public function getTotalSales(): int
    {
        return (int) Sale::query()->sum('total_price');
    }

    public function getTotalOrders(): int
    {
        return (int) Sale::query()->count();
    }

    public function getAvgOrderValue(): int
    {
        $count = (int) Sale::query()->count();
        if ($count === 0) return 0;

        return (int) floor(((int) Sale::query()->sum('total_price')) / $count);
    }

    public function rupiah(int $value): string
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }
}
