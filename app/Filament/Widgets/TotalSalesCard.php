<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\Widget;

class TotalSalesCard extends Widget
{
    protected string $view = 'filament.widgets.sales.total-sales-card';

    protected int|string|array $columnSpan = 1;

    public function total(): int
    {
        return (int) Sale::query()->sum('total_price');
    }

    public function rupiah(int $v): string
    {
        return 'Rp. ' . number_format($v, 0, ',', '.');
    }
}
