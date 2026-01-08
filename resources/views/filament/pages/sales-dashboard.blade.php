@php
    use App\Models\Sale;

    $totalSales = (int) Sale::query()->sum('total_price');
    $totalOrders = (int) Sale::query()->count();
    $avgOrder = $totalOrders > 0 ? (int) floor($totalSales / $totalOrders) : 0;

    $rupiah = fn (int $v) => 'Rp. ' . number_format($v, 0, ',', '.');

    use App\Filament\Widgets\SalesRevenueChartWidget;
    use App\Filament\Widgets\SalesOrdersTableWidget;
@endphp

<x-filament::page>
    <div class="space-y-6">
<div style="display: grid; margin-bottom: 20px; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px;">
    <x-filament::card>
        <div class="not-prose text-sm opacity-70">Total Sales</div>
        <div class="not-prose mt-1 text-xl font-semibold">
            {{ $rupiah($totalSales) }}
        </div>
    </x-filament::card>

    <x-filament::card>
        <div class="not-prose text-sm opacity-70">Total Orders</div>
        <div class="not-prose mt-1 text-xl font-semibold">
            {{ number_format($totalOrders, 0, ',', '.') }}
        </div>
    </x-filament::card>

    <x-filament::card>
        <div class="not-prose text-sm opacity-70">Avg. Order Value</div>
        <div class="not-prose mt-1 text-xl font-semibold">
            {{ $rupiah($avgOrder) }}
        </div>
    </x-filament::card>
</div>

    <div style="margin-bottom: 20px">

        @livewire(SalesRevenueChartWidget::class)
    </div>
        @livewire(SalesOrdersTableWidget::class)

    </div>
</x-filament::page>
