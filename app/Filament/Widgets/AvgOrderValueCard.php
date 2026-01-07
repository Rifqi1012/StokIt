<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\Widget;

class AvgOrderValueCard extends Widget
{
    protected string $view = 'filament.widgets.sales.avg-order-value-card';

    protected int|string|array $columnSpan = 1;

    public function avg(): int
    {
        $count = (int) Sale::query()->count();
        if ($count === 0) return 0;

        return (int) floor(((int) Sale::query()->sum('total_price')) / $count);
    }

    public function rupiah(int $v): string
    {
        return 'Rp. ' . number_format($v, 0, ',', '.');
    }
}
