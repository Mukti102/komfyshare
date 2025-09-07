<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrderChart extends ChartWidget
{
    protected static ?string $heading = 'Order Per Bulan';

    protected function getData(): array
    {
        // Ambil data order per bulan (1 tahun terakhir)
        $orders = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Buat label bulan (Jan - Dec)
        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('F', mktime(0, 0, 0, $i, 1)); // Nama bulan
            $data[] = $orders[$i] ?? 0; // Kalau ga ada order, kasih 0
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Order',
                    'data' => $data,
                    'fill' => 'start', // biar ada shading di line chart
                    'tension' => 0.3,  // buat curve halus
                    'borderColor' => '#22c55e',     // warna garis (ini hijau Tailwind "success")
                    'backgroundColor' => 'rgba(34,197,94,0.2)', // warna shading area
                    'pointBackgroundColor' => '#22c55e', // warna titik
                    'pointBorderColor' => '#fff',   // border titik
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // bisa diganti 'bar' kalau mau
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full'; // atau bisa angka 2, 3, 4 tergantung grid
    }
}
