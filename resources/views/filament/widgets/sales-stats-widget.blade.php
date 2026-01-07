<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
    <x-filament::card>
        <div class="not-prose text-sm opacity-70">Total Sales</div>
        <div class="not-prose mt-1 text-xl font-semibold">
            {{ $this->rupiah($this->getTotalSales()) }}
        </div>
    </x-filament::card>

    <x-filament::card>
        <div class="not-prose text-sm opacity-70">Total Orders</div>
        <div class="not-prose mt-1 text-xl font-semibold">
            {{ number_format($this->getTotalOrders(), 0, ',', '.') }}
        </div>
    </x-filament::card>

    <x-filament::card>
        <div class="not-prose text-sm opacity-70">Avg. Order Value</div>
        <div class="not-prose mt-1 text-xl font-semibold">
            {{ $this->rupiah($this->getAvgOrderValue()) }}
        </div>
    </x-filament::card>
</div>
