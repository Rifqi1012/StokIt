<?php

namespace App\Filament\Resources\DamagedStocks;

use App\Filament\Resources\DamagedStocks\Pages\CreateDamagedStock;
use App\Filament\Resources\DamagedStocks\Pages\EditDamagedStock;
use App\Filament\Resources\DamagedStocks\Pages\ListDamagedStocks;
use App\Filament\Resources\DamagedStocks\Schemas\DamagedStockForm;
use App\Filament\Resources\DamagedStocks\Tables\DamagedStocksTable;
use App\Models\DamagedStock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DamagedStockResource extends Resource
{
    protected static ?string $model = DamagedStock::class;

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'Inventory';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static ?string $pluralModelLabel = "Damaged Stock";

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DamagedStockForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DamagedStocksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDamagedStocks::route('/'),
            'create' => CreateDamagedStock::route('/create'),
            'edit' => EditDamagedStock::route('/{record}/edit'),
        ];
    }
}
