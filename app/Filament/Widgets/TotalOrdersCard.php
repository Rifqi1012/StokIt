<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\Widget;

class TotalOrdersCard extends Widget
{
    protected string $view = 'filament.widgets.sales.total-orders-card';

    protected int|string|array $columnSpan = 1;

    public function total(): int
    {
        return (int) Sale::query()->count();
    }
}
