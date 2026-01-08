<?php

namespace App\Filament\Resources\Inventories;

use App\Filament\Resources\Inventories\Pages\CreateInventory;
use App\Filament\Resources\Inventories\Pages\EditInventory;
use App\Filament\Resources\Inventories\Pages\ListInventories;
use App\Filament\Resources\Inventories\Schemas\InventoryForm;
use App\Filament\Resources\Inventories\Tables\InventoriesTable;
use App\Models\Inventory;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;


class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getNavigationBadge(): ?string
    {
        $count = (int) DB::table('inventories')
            ->join('categories', 'categories.id', '=', 'inventories.category_id')
            ->where('inventories.stock', '>', 0)
            ->whereColumn('inventories.stock', '<=', 'categories.min_stock')
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger'; 
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Produk yang stoknya mendekati minimum';
    }



    protected static ?string $pluralModelLabel = "Inventory";

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'Inventory';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-cube';
    }

    public static function form(Schema $schema): Schema
    {
        return InventoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoriesTable::configure($table);
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
            'index' => ListInventories::route('/'),
            'create' => CreateInventory::route('/create'),
            'edit' => EditInventory::route('/{record}/edit'),
        ];
    }
}
