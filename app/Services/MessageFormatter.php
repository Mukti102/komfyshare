<?php

namespace App\Services;

use Carbon\Carbon;

class MessageFormatter
{
    public static function format($template, $order, $customer)
    {   
    
        return str_replace(
            [
                '{NAMA}',
                '{PRODUK}',
                '{SLOT}',
                '{INVOICE}',
                '{TGL_MULAI}',
                '{TGL_AKHIR}',
                '{SISA_HARI}',
            ],
            [
                $customer->name,
                $order->product->title,
                $order->quantity,
                $order->invoice,
                $order->start_date->format('d/m/Y'),
                $order->end_date->format('d/m/Y'),
                Carbon::now()->diffInDays($order->end_date, false),
            ],
            $template
        );
    }
}
