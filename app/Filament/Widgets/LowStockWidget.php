<?php

namespace App\Filament\Widgets;

use App\Models\Inventory;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class LowStockWidget extends Widget
{
    protected string $view = 'filament.widgets.low-stock-widget';

    protected int|string|array $columnSpan = 1;

    public function getLowStockCount(): int
    {
        return Inventory::query()
            ->join('categories', 'categories.id', '=', 'inventories.category_id')
            ->where('inventories.stock', '>', 0)
            ->whereColumn('inventories.stock', '<=', 'categories.min_stock')
            ->count();
    }
}
