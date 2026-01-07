<x-filament::card>
    <div class="not-prose text-sm opacity-70">Total Sales</div>
    <div class="not-prose mt-1 text-xl font-semibold">
        {{ $this->rupiah($this->total()) }}
    </div>
</x-filament::card>
