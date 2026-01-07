<?php

namespace App\Filament\Resources\DamagedStocks\Pages;

use App\Filament\Resources\DamagedStocks\DamagedStockResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDamagedStock extends EditRecord
{
    protected static string $resource = DamagedStockResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return [
            'reason' => $data['reason'] ?? null,
            'notes'  => $data['notes'] ?? null,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
