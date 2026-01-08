<x-filament::widget>
    <x-filament::card>
        <div class="not-prose">
            <div style="font-weight: bold; font-size: large;"">
                Low Stock
            </div>

            <div style="margin-top: 10px">
                {{ $this->getLowStockCount() }} products are running low
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
