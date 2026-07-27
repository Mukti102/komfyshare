<?php

namespace App\Filament\Widgets;

use App\Models\CheckerOrder;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CheckerOrderChart extends ChartWidget
{
    protected static ?string $heading = 'Pesanan Checker Per Bulan';
    
    protected static ?int $sort = 5;

    public function getColumnSpan(): int|string|array
    {
        return 1; // Fits beside another widget
    }

    protected function getData(): array
    {
        // Ambil data order per bulan (1 tahun terakhir)
        $orders = CheckerOrder::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('F', mktime(0, 0, 0, $i, 1)); // Nama bulan
            $data[] = $orders[$i] ?? 0; // Kalau ga ada order, kasih 0
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Dokumen Dicek',
                    'data' => $data,
                    'fill' => 'start',
                    'tension' => 0.3,
                    'borderColor' => '#3b82f6',     // warna biru
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)', // shading biru
                    'pointBackgroundColor' => '#3b82f6',
                    'pointBorderColor' => '#fff',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
