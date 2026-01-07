<x-filament::widget>
    <x-filament::card>
        <div class="not-prose">
            <div class="text-xl font-semibold">
                Low Stock
            </div>

            <div class="mt-4 text-center text-sm font-semibold text-white">
                {{ $this->getLowStockCount() }} products are running low
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
