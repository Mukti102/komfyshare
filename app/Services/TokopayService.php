<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TokopayService
{
    protected $baseUrl;
    protected $apiKey;
    protected $merchantId;

    public function __construct()
    {
        $this->baseUrl = config('tokopay.base_url');
        $this->apiKey = setting('tokopay.api_key') ?? config('tokopay.api_key');
        $this->merchantId = setting('tokopay.merchant_id') ?? config('tokopay.merchant_id');
    }

    public function createOrder($codeMethod, $refId, $nominal)
    {   
        $amount = (int) number_format($nominal, 0, '', ''); 
        try {
            $response = Http::get("{$this->baseUrl}/order", [
                'merchant' => $this->merchantId,
                'secret'   => $this->apiKey,
                'ref_id'   => $refId,
                'nominal'  => $amount,
                'metode'   => $codeMethod,
            ]);

            Log::info('api create order',['message' => $response]);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'status'  => false,
                'code'    => $response->status(),
                'message' => $response->body(),
            ];
        } catch (\Exception $e) {
            return [
                'status'  => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function checkStatus($codeMethod, $refId, $nominal)
    {   
        $amount = (int) number_format($nominal, 0, '', ''); 
        try {
            $response = Http::get("{$this->baseUrl}/order", [
                'merchant' => $this->merchantId,
                'secret'   => $this->apiKey,
                'ref_id'   => $refId,
                'nominal'  => $amount,
                'metode'   => $codeMethod,
            ]);

            Log::info('api create order',['message' => $response]);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'status'  => false,
                'code'    => $response->status(),
                'message' => $response->body(),
            ];
        } catch (\Exception $e) {
            return [
                'status'  => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
