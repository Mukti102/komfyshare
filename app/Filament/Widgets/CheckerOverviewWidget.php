<?php

namespace App\Filament\Widgets;

use App\Models\CheckerOrder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CheckerOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Checker Orders', CheckerOrder::count())
                ->description('All time KomfyChecker orders')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            Stat::make('Pending / Processing', CheckerOrder::whereIn('status', ['pending', 'processing'])->count())
                ->description('Orders awaiting completion')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Checker Revenue (Monthly)', 'Rp ' . number_format(CheckerOrder::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('total_price'), 0, ',', '.'))
                ->description('Completed orders this month')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}
