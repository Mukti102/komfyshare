<?php

namespace App\Http\Controllers;

use App\Models\CheckerService;
use App\Models\CheckerOrder;
use Illuminate\Http\Request;
use App\Services\TokopayService;

class CheckerFrontendController extends Controller
{   
     protected $tokopay;

    public function __construct(TokopayService $tokopay)
    {
        $this->tokopay = $tokopay;
    }

    public function landing()
    {
        $services = CheckerService::where('status', true)->orderBy('sort_order')->get();
        return view('pages.checker.landing', compact('services'));
    }

    public function form($slug)
    {
        $service = CheckerService::where('slug', $slug)->firstOrFail();
        return view('pages.checker.form', compact('service'));
    }

    public function checkout($invoice)
    {
        $order = CheckerOrder::with('service', 'package')->where('invoice_number', $invoice)->firstOrFail();
        return view('pages.checker.checkout', compact('order'));
    }

    public function payment($invoice)
    {
        $order = CheckerOrder::with('service', 'package')->where('invoice_number', $invoice)->firstOrFail();
        $data = $this->tokopay->createOrder($order->paymentMethod->code, $order->invoice_number, $order->total_price);
         if (!isset($data['data']) || $data['status'] == false) {
            return redirect()->route('checker.checkout', $order->invoice_number)->with('error','Gagal Memproses Order');
        }
        
        return view('pages.checker.payment', compact('order', 'data'));

    }

    public function track()
    {
        return view('pages.checker.track');
    }

    public function trackDetail($invoice)
    {
        $order = CheckerOrder::with(['customer', 'service', 'package', 'paymentMethod', 'statusLogs' => function($q) {
            $q->orderBy('created_at', 'desc');
        }, 'files'])->where('invoice_number', $invoice)->firstOrFail();

        return view('pages.checker.track_detail', compact('order'));
    }
}
