<?php

namespace App\Filament\Widgets;

use App\Models\CheckerOrder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CheckerOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', CheckerOrder::count())
                ->description('All time checker orders')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),
            Stat::make('Pending Orders', CheckerOrder::where('status', 'pending')->count())
                ->description('Awaiting process')
                ->color('warning'),
            Stat::make('Monthly Revenue', 'Rp ' . number_format(CheckerOrder::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('total_price'), 0, ',', '.'))
                ->description('Completed orders this month')
                ->color('success'),
        ];
    }
}
