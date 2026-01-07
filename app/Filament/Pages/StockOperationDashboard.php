<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class StockOperationDashboard extends Page
{
    protected string $view = 'filament.pages.stock-operation-dashboard';

    public static function getNavigationLabel(): string
    {
        return 'Stock Operation';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-chart-pie';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->role === 'admin';
    }
}
