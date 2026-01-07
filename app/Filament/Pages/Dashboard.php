<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            // BARIS 1 (kiri -> kanan)
            \App\Filament\Widgets\InventoryOverviewWidget::class,
            \App\Filament\Widgets\SalesChartWidget::class,

            // BARIS 2 (kiri -> kanan)
            \App\Filament\Widgets\LowStockWidget::class,
            \App\Filament\Widgets\RecentTransactionsWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 2; // ✅ paksa 2 kolom
    }
}
