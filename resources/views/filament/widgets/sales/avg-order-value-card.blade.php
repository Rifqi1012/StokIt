<x-filament::card>
    <div class="not-prose text-sm opacity-70">Avg. Order Value</div>
    <div class="not-prose mt-1 text-xl font-semibold">
        {{ $this->rupiah($this->avg()) }}
    </div>
</x-filament::card>
