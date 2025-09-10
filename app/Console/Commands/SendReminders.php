<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Services\MessageFormatter;
use App\Jobs\SendWhatsapp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendReminders extends Command
{
    protected $signature = 'reminder:send';
    protected $description = 'Kirim pesan WA reminder dan milestone';

    public function handle()
    {
        $today = Carbon::today();

        $orders = Order::with('costumer', 'product')->where('status', 'completed')->get();

        foreach ($orders as $order) {


            $customer = $order->costumer;


            if (isset($order->end_date)) {
                // Reminder H-2
                if ($today->isSameDay($order->end_date->copy()->subDays(2))) {
                    Log::info('h2', ['h2']);

                    $message = MessageFormatter::format(config('messages.reminder_p2'), $order, $customer);
                    SendWhatsapp::dispatch($customer->phone, $message);
                }

                // Reminder H-0
                if ($today->isSameDay($order->end_date)) {
                    Log::info('h0', ['h0']);


                    $message = MessageFormatter::format(config('messages.reminder_p1'), $order, $customer);

                    SendWhatsapp::dispatch($customer->phone, $message);
                }
            }

            if (isset($order->start_date)) {
                Log::info('bulan2', ['milstone']);

                // Milestone bulan ke-2
                if ($today->isSameDay($order->start_date->copy()->addMonths(2))) {
                    $message = MessageFormatter::format(config('messages.milestone_m2'), $order, $customer);
                    SendWhatsapp::dispatch($customer->phone, $message);
                }

                // Milestone bulan ke-3
                if ($today->isSameDay($order->start_date->copy()->addMonths(3))) {
                    Log::info('bulan3', ['milstone']);
                    $message = MessageFormatter::format(config('messages.milestone_m3'), $order, $customer);
                    SendWhatsapp::dispatch($customer->phone, $message);
                }
            }
        }

        $this->info("Reminder & milestone WA sudah dikirim.");
    }
}
