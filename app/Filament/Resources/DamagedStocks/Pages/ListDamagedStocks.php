<?php

namespace App\Filament\Resources\DamagedStocks\Pages;

use App\Filament\Resources\DamagedStocks\DamagedStockResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDamagedStocks extends ListRecords
{
    protected static string $resource = DamagedStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make() ->label("+ Add Damaged Stock"),
        ];
    }
}
