<?php

namespace App\Filament\Resources\DamagedStocks\Pages;

use App\Filament\Resources\DamagedStocks\DamagedStockResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Inventory;

class CreateDamagedStock extends CreateRecord
{
    protected static string $resource = DamagedStockResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $inventory = Inventory::find($data['inventory_id']);

        if (! $inventory) {
            throw ValidationException::withMessages([
                'inventory_id' => 'Product tidak ditemukan.',
            ]);
        }

        $data['available_stock'] = (int) $inventory->stock;

        if ((int) $data['damaged_qty'] > (int) $inventory->stock) {
            throw ValidationException::withMessages([
                'damaged_qty' => 'Jumlah rusak melebihi stock tersedia.',
            ]);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $damaged = $this->record;

        DB::transaction(function () use ($damaged) {
            $inventory = Inventory::query()
                ->lockForUpdate()
                ->find($damaged->inventory_id);

            if (! $inventory) {
                throw ValidationException::withMessages([
                    'inventory_id' => 'Product tidak ditemukan.',
                ]);
            }

            if ((int) $inventory->stock < (int) $damaged->damaged_qty) {
                throw ValidationException::withMessages([
                    'damaged_qty' => 'Stock tidak mencukupi.',
                ]);
            }

            $inventory->decrement('stock', (int) $damaged->damaged_qty);
        });
    }
}
