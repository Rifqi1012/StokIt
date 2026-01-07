<x-filament::card>
    <div class="not-prose text-sm opacity-70">Total Orders</div>
    <div class="not-prose mt-1 text-xl font-semibold">
        {{ number_format($this->total(), 0, ',', '.') }}
    </div>
</x-filament::card>
