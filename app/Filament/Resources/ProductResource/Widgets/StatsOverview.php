<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Costumer;  // pastikan ini memang ada di app/Models
use App\Models\Order;     // ini juga harus ada
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Share Orders', Order::count())
                ->description('All time KomfyShare orders')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
            Stat::make('Active Costumers', Costumer::count())
                ->description('Registered costumers')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
            Stat::make('Share Revenue (Monthly)', 'Rp ' . number_format(Order::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('amount'), 0, ',', '.'))
                ->description('Completed orders this month')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}
