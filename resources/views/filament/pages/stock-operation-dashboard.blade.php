@php
    use Illuminate\Support\Facades\DB;

    $barangMasuk = (int) DB::table('inventories')->sum('stock');

    $barangRusak = (int) DB::table('damaged_stocks')->sum('damaged_qty');

    $daftarBarang = (int) DB::table('stock_adjustments')->sum('production_qty');

    $revenue = (int) DB::table('sales')->sum('total_price');

    $salesQty = (int) DB::table('sales')->sum('qty');

    $hpp = (int) DB::table('sales')
        ->join('inventories', 'inventories.id', '=', 'sales.inventory_id')
        ->selectRaw('COALESCE(SUM(sales.qty * inventories.price), 0) as hpp')
        ->value('hpp');

    $lossDamaged = (int) DB::table('damaged_stocks')
        ->join('inventories', 'inventories.id', '=', 'damaged_stocks.inventory_id')
        ->selectRaw('COALESCE(SUM(damaged_stocks.damaged_qty * inventories.price), 0) as loss')
        ->value('loss');

    $labaKotor  = $revenue - $hpp;
    $labaBersih = $labaKotor - $lossDamaged;
    $barangKeluar = $salesQty - $barangRusak;
    $daftarBarangReal = $daftarBarang - $barangKeluar;

    $rupiah = fn (int $v) => 'Rp. ' . number_format($v, 0, ',', '.');
@endphp

<x-filament::page>
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 22px;
        }
        @media (max-width: 1100px) {
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 640px) {
            .stats-grid { grid-template-columns: 1fr; }
        }
        .card-label { font-size: 14px; opacity: .7; }
        .card-value { margin-top: 6px; font-size: 20px; font-weight: 600; }
        .card-sub { margin-top: 6px; font-size: 12px; opacity: .65; }
    </style>

    <div class="stats-grid">
        <x-filament::card>
            <div style="padding: 6px 0;">
                <div class="card-label">Barang Masuk (Stock)</div>
                <div class="card-value">{{ number_format($barangMasuk, 0, ',', '.') }}</div>
                <div class="card-sub">Total stok tersedia di inventory</div>
            </div>
        </x-filament::card>
        <x-filament::card>
            <div style="padding: 6px 0;">
                <div class="card-label">Barang Keluar</div>
                <div class="card-value">{{ number_format($barangKeluar, 0, ',', '.') }}</div>
                <div class="card-sub">Barang Rusak dan Barang Terjual</div>
            </div>
        </x-filament::card>

        <x-filament::card>
            <div style="padding: 6px 0;">
                <div class="card-label">Barang Rusak</div>
                <div class="card-value">{{ number_format($barangRusak, 0, ',', '.') }}</div>
                <div class="card-sub">Total qty rusak (Damaged Stocks)</div>
            </div>
        </x-filament::card>

        <x-filament::card>
            <div style="padding: 6px 0;">
                <div class="card-label">HPP (COGS)</div>
                <div class="card-value">{{ $rupiah($hpp) }}</div>
                <div class="card-sub">Σ(qty terjual × harga beli)</div>
            </div>
        </x-filament::card>

        <x-filament::card>
            <div style="padding: 6px 0;">
                <div class="card-label">Laba Kotor</div>
                <div class="card-value">{{ $rupiah($labaKotor) }}</div>
                <div class="card-sub">Revenue − HPP</div>
            </div>
        </x-filament::card>

        <x-filament::card>
            <div style="padding: 6px 0;">
                <div class="card-label">Laba Bersih</div>
                <div class="card-value">{{ $rupiah($labaBersih) }}</div>
                <div class="card-sub">Laba kotor − kerugian barang rusak</div>
            </div>
        </x-filament::card>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px;">
        <x-filament::card>
            <div style="padding: 6px 0;">
                <div class="card-label">Total Revenue</div>
                <div class="card-value">{{ $rupiah($revenue) }}</div>
                <div class="card-sub">Σ total_price dari Sales</div>
            </div>
        </x-filament::card>

        <x-filament::card>
            <div style="padding: 6px 0;">
                <div class="card-label">Kerugian Barang Rusak</div>
                <div class="card-value">{{ $rupiah($lossDamaged) }}</div>
                <div class="card-sub">Σ(damaged_qty × harga beli)</div>
            </div>
        </x-filament::card>
    </div>
</x-filament::page>
