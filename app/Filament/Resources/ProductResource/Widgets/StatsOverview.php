<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Costumer;  // pastikan ini memang ada di app/Models
use App\Models\Order;     // ini juga harus ada
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Product', Product::count()),
            Stat::make('Costumer', Costumer::count()),
            Stat::make('Orderan Hari ini', Order::whereDate('created_at', today())->count()),
        ];
    }
}
