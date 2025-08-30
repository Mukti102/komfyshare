<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class SendWhatsapp implements ShouldQueue
{
    use Queueable;

    protected $phone;
    protected $message;

    /**
     * Create a new job instance.
     */
    public function __construct($phone, $message)
    {
        $this->phone   = $phone;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $phone = $this->normalizePhone($this->phone);

        Http::withHeaders([
            // 'Authorization' => env('FONNTE_TOKEN'),
            'Authorization' => 'GJu2qM8YKF47K8PC1b3u',
        ])->post('https://api.fonnte.com/send', [
            'target'  => $phone,
            'message' => $this->message,
        ]);
    }


    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone); 

        if (str_starts_with($phone, '0')) {
            // 08123... -> 628123...
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '62')) {
            // sudah benar -> biarkan
            $phone = $phone;
        } elseif (str_starts_with($phone, '+62')) {
            // +628123 -> 628123
            $phone = ltrim($phone, '+');
        } else {
            // fallback: anggap sudah benar
            $phone = $phone;
        }

        return $phone;
    }
}
