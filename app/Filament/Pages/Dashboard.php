<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\DB;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\InventoryOverviewWidget::class,
            \App\Filament\Widgets\SalesChartWidget::class,
            \App\Filament\Widgets\LowStockWidget::class,
            \App\Filament\Widgets\RecentTransactionsWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 2;
    }

    public static function getNavigationBadge(): ?string
    {
        $count = (int) DB::table('inventories')
            ->join('categories', 'categories.id', '=', 'inventories.category_id')
            ->where('inventories.stock', '>', 0)
            ->whereColumn('inventories.stock', '<=', 'categories.min_stock')
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Produk yang stoknya mendekati minimum';
    }
}
