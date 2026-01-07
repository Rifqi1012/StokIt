<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use App\Filament\Resources\Sales\SaleResource;
use Illuminate\Support\Facades\Auth;

class SalesDashboard extends Page
{
    protected string $view = 'filament.pages.sales-dashboard';

    public static function getNavigationLabel(): string
    {
        return 'Sales Dashboard';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-chart-bar';
    }


    public function getTitle(): string
    {
        return 'SALES';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('addOrder')
                ->label('+ Add Order')
                ->url(SaleResource::getUrl('create'))
                ->button(),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->role === 'admin';
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Sales';
    }
}
