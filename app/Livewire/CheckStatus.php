<?php

namespace App\Livewire;

use App\Services\TokopayService;
use Livewire\Component;

class CheckStatus extends Component
{   
    public $data;
    public $order;
    public $status;
    protected $tokopay;

    public function mount(TokopayService $tokopay,$data, $order)
    {   
        $this->tokopay = $tokopay;
        $this->data = $data['data'];
        $this->status = $data['data']['status'] ?? null;
        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.check-status');
    }


    public function checkStatus()
    {   
        $tokopay = app(TokopayService::class);
        $invoice = $this->order instanceof \App\Models\CheckerOrder ? $this->order->invoice_number : $this->order->invoice;
        $amount = $this->order instanceof \App\Models\CheckerOrder ? $this->order->total_price : $this->order->amount;

        $response = $tokopay->checkStatus(
            $this->order->paymentMethod->code,
            $invoice,
            $amount
        );
        $this->status = $response['data']['status'] ?? null;
    }
}
