<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsapp implements ShouldQueue
{
    use Queueable;

    protected $phone;
    protected $message;

    public function __construct($phone, $message)
    {
        $this->phone   = $phone;
        $this->message = $message;
    }

    public function handle(): void
    {

        $token = setting('wablas.token') ?? env('TOKEN_WABLAS');
        $secret_key = setting('wablas.secret_key') ?? env('SECRET_KEY_WABLAS');
        $baseUrl = setting('wablas.base_url') ?? env('BASE_URL_WABLAS');

        $phone = $this->normalizePhone($this->phone);
        $message = $this->message;

        // URL encode the message
        $message_encoded = urlencode($message);

        // Build API URL
        $api_url = "{$baseUrl}?token={$token}.{$secret_key}&phone={$phone}&message={$message_encoded}";

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // Execute request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            // echo "cURL Error: " . curl_error($ch);
            Log::info('send whatsapp error',['message' => $ch]);
        } else {
            Log::info('send whatsapp error',['message' => json_decode($response, true)]);
        }

    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '+62')) {
            $phone = ltrim($phone, '+');
        }

        return $phone;
    }
}
