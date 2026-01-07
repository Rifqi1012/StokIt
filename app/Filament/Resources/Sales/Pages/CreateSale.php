<?php

namespace App\Filament\Resources\Sales\Pages;

use App\Filament\Resources\Sales\SaleResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Inventory;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;


class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;

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

        $data['total_price'] = (int) $data['qty'] * (int) $inventory->selling_price;

        return $data;
    }

    protected function afterCreate(): void
    {
        $sale = $this->record;

        DB::transaction(function () use ($sale) {
            $inventory = Inventory::query()->lockForUpdate()->find($sale->inventory_id);

            if (! $inventory) {
                throw ValidationException::withMessages([
                    'inventory_id' => 'Product tidak ditemukan.',
                ]);
            }

            if ((int) $inventory->stock < (int) $sale->qty) {
                throw ValidationException::withMessages([
                    'qty' => 'Stock tidak mencukupi.',
                ]);
            }

            $inventory->decrement('stock', (int) $sale->qty);
        });
    }
}
