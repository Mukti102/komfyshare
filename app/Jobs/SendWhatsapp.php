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

        $mode = setting('wablas.mode') ?? 'production';
        $testingNumbers = setting('wablas.testing_numbers') ?? [];
        
        $originalPhone = $this->normalizePhone($this->phone);
        $message = $this->message;

        $targetPhones = [];

        if ($mode === 'testing') {
            // Jika mode testing aktif, ganti isi pesan dan kirim ke nomor developer
            $message = "[TESTING MODE - Target Asli: {$originalPhone}]\n\n" . $message;
            
            if (empty($testingNumbers)) {
                Log::warning('WhatsApp Testing Mode aktif, tetapi tidak ada nomor testing yang didaftarkan. Pesan dihentikan.');
                return;
            }

            foreach ($testingNumbers as $tn) {
                $targetPhones[] = $this->normalizePhone($tn);
            }
        } else {
            // Mode produksi
            $targetPhones[] = $originalPhone;
        }

        $message_encoded = urlencode($message);

        foreach ($targetPhones as $targetPhone) {
            // Build API URL
            $api_url = "{$baseUrl}?token={$token}.{$secret_key}&phone={$targetPhone}&message={$message_encoded}";

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
                Log::error('send whatsapp error', ['message' => curl_error($ch), 'target' => $targetPhone]);
            } else {
                Log::info('send whatsapp success', ['response' => json_decode($response, true), 'target' => $targetPhone]);
            }
            curl_close($ch);
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
