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
        $response = $tokopay->checkStatus(
            $this->order->paymentMethod->code,
            $this->order->invoice,
            $this->order->amount
        );
        $this->status = $response['data']['status'];
    }
}
