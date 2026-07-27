<?php

namespace App\Livewire\Checker;

use App\Models\CheckerAnswer;
use App\Models\CheckerFile;
use App\Models\CheckerOrder;
use App\Models\CheckerQuestion;
use App\Models\Costumer;
use App\Models\CheckerStatusLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\PaymentMetods;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use App\Services\Checker\PricingService;

class ServiceForm extends Component
{
    use WithFileUploads;

    public $service;
    public $questions;

    public $step = 1;

    // Step 1: Customer Data
    public $customer_name;
    public $customer_whatsapp;
    public $whatsapp_check_status;

    // Step 2: Answers (text/textarea/checkbox only)
    public $answers = [];

    // Step 2: File uploads — top-level property so Livewire handles it correctly
    // Associative array: question_id => array of files
    public $document_files = [];

    // Promo Code
    public $promo_code = '';
    public $checker_coupon_id = null;
    public $discount_amount = 0;

    // Token Usage
    public $available_wallet_id = null;
    public $required_token = 0;
    public $use_token = false;

    public function mount($service)
    {
        $this->service = $service;
        $this->questions = CheckerQuestion::with('options')
            ->where('checker_service_id', $service->id)
            ->orderBy('sort_order')
            ->get();

        foreach ($this->questions as $question) {
            if ($question->field_type === 'file') {
                $this->document_files[$question->id] = [];
            } else {
                // If it's a checkbox with options, initialize as an array so Livewire handles multiple selections correctly
                if ($question->field_type === 'checkbox' && $question->options->count() > 0) {
                    $this->answers[$question->id] = [];
                } else {
                    $this->answers[$question->id] = '';
                }
            }
        }
    }

    public function checkWhatsApp()
    {
        $this->validate(['customer_whatsapp' => 'required|string']);
        $customer = Costumer::where('phone', $this->customer_whatsapp)->first();
        
        $this->available_wallet_id = null;
        $this->required_token = 0;
        $this->use_token = false;

        if ($customer) {
            $this->customer_name = $customer->name;
            $this->whatsapp_check_status = 'found';

            // Check if customer has an active wallet that supports this service
            $wallet = \App\Models\CheckerTokenWallet::where('customer_id', $customer->id)
                ->active()
                ->whereHas('package.packageServices', function($q) {
                    $q->where('checker_service_id', $this->service->id);
                })
                ->with(['package.packageServices' => function($q) {
                    $q->where('checker_service_id', $this->service->id);
                }])
                ->get()
                ->filter(function($w) {
                    $cost = $w->package->packageServices->first()->token_cost ?? 999999;
                    return $w->total_token >= $cost;
                })
                ->first();

            if ($wallet) {
                $this->available_wallet_id = $wallet->id;
                $this->required_token = $wallet->package->packageServices->first()->token_cost;
            }

        } else {
            $this->whatsapp_check_status = 'not_found';
        }
    }

    public function removeFile($questionId, $index)
    {
        $index = (int) $index;
        if (isset($this->document_files[$questionId][$index])) {
            // Delete the temporary file
            if (method_exists($this->document_files[$questionId][$index], 'delete')) {
                $this->document_files[$questionId][$index]->delete();
            }
            unset($this->document_files[$questionId][$index]);
            $this->document_files[$questionId] = array_values($this->document_files[$questionId]);
        }
    }

    #[Computed]
   public function totalPrice()
{
    $basePrice = app(PricingService::class)->calculate(
        service: $this->service,
        answers: $this->answers,
        uploads: $this->document_files,
    );
    
    return max(0, $basePrice - $this->discount_amount);
}

    #[Computed]
    public function originalPrice()
    {
        return app(PricingService::class)->calculate(
            service: $this->service,
            answers: $this->answers,
            uploads: $this->document_files,
        );
    }

    public function applyCoupon()
    {
        $this->validate(['promo_code' => 'required|string']);
        
        $coupon = \App\Models\CheckerCoupon::where('code', strtoupper($this->promo_code))
            ->where('status', true)
            ->where('sisa_stock', '>', 0)
            ->where(function($q) {
                $q->whereNull('expired_date')->orWhere('expired_date', '>=', now());
            })->first();

        if (!$coupon) {
            $this->addError('promo_code', 'Kode promo tidak valid, habis, atau kedaluwarsa.');
            $this->removeCoupon();
            return;
        }

        $basePrice = $this->originalPrice;
        $discount = 0;

        if (!empty($coupon->percentase_discount)) {
            $discount = $basePrice * ($coupon->percentase_discount / 100);
        } elseif (!empty($coupon->rupiah_discount)) {
            $discount = $coupon->rupiah_discount;
        }

        $this->checker_coupon_id = $coupon->id;
        $this->discount_amount = $discount;
        $this->resetErrorBag('promo_code');
        session()->flash('promo_success', 'Kode promo berhasil digunakan!');
    }

    public function removeCoupon()
    {
        $this->promo_code = '';
        $this->checker_coupon_id = null;
        $this->discount_amount = 0;
    }

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'customer_name' => 'required|string|max:255',
                'customer_whatsapp' => 'required|string|max:20',
            ]);
            $this->step++;
        }
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function submit()
    {
        // 1. Validate answers and uploads
        $rules = [];
        $messages = [];
        foreach ($this->questions as $q) {
            if ($q->is_required) {
                if ($q->field_type === 'file') {
                    $rules['document_files.' . $q->id] = 'required|array|min:1'; 
                    $rules['document_files.' . $q->id . '.*'] = 'file|mimes:pdf,docx|max:2048';
                    $messages['document_files.' . $q->id . '.required'] = $q->label . ' wajib diunggah.';
                    $messages['document_files.' . $q->id . '.*.mimes'] = $q->label . ' hanya mendukung format PDF atau DOCX.';
                    $messages['document_files.' . $q->id . '.*.max'] = $q->label . ' ukuran maksimal 2MB per file.';
                } elseif ($q->field_type === 'checkbox') {
                    // optional
                } else {
                    $rules['answers.' . $q->id] = 'required';
                    $messages['answers.'.$q->id.'.required'] = $q->label.' wajib diisi.';
                }
            }
        }
        $this->validate($rules, $messages);

        DB::beginTransaction();

        try {
            // 1. Find or Create Customer
            $customer = Costumer::firstOrCreate(
                ['phone' => $this->customer_whatsapp],
                ['name' => $this->customer_name]
            );

            // 2. Generate Invoice Number
            $invoice = 'CHK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // Token Usage Calculation
            $finalPaymentType = $this->use_token ? 'token' : 'midtrans';
            $finalTotalPrice = $this->use_token ? 0 : $this->totalPrice;
            $finalStatus = $this->use_token ? 'paid' : 'waiting_payment';

            // 3. Create Order
            $order = CheckerOrder::create([
                'invoice_number' => $invoice,
                'customer_id' => $customer->id,
                'checker_service_id' => $this->service->id,
                'payment_type' => $finalPaymentType, 
                'original_price' => $this->originalPrice,
                'discount_amount' => $this->use_token ? 0 : $this->discount_amount,
                'checker_coupon_id' => $this->use_token ? null : $this->checker_coupon_id,
                'token_used' => $this->use_token ? $this->required_token : 0,
                'total_price' => $finalTotalPrice, 
                'status' => $finalStatus,
            ]);

            if ($this->use_token) {
                // Deduct Token
                $wallet = \App\Models\CheckerTokenWallet::find($this->available_wallet_id);
                if ($wallet) {
                    $balanceBefore = $wallet->total_token;
                    $wallet->decrement('total_token', $this->required_token);
                    
                    \App\Models\CheckerTokenHistory::create([
                        'checker_token_wallet_id' => $wallet->id,
                        'checker_order_id' => $order->id,
                        'type' => 'usage',
                        'token' => $this->required_token,
                        'balance_before' => $balanceBefore,
                        'balance_after' => $balanceBefore - $this->required_token,
                        'description' => 'Pembayaran Layanan ' . $this->service->name,
                    ]);
                }
            } else {
                // 3.5 Decrease Coupon Stock if used
                if ($this->checker_coupon_id) {
                    \App\Models\CheckerCoupon::where('id', $this->checker_coupon_id)->decrement('sisa_stock');
                }
            }

            // 4. Save Files
            foreach ($this->questions as $q) {
                if ($q->field_type === 'file' && !empty($this->document_files[$q->id])) {
                    $filePaths = [];
                    foreach ($this->document_files[$q->id] as $file) {
                        $path = $file->store('checker_files', 'public');
                        
                        // Map field_name to valid enum category ('original', 'support', 'turnitin', 'revision', 'result')
                        $category = match (true) {
                            str_contains(strtolower($q->field_name), 'turnitin') => 'turnitin',
                            str_contains(strtolower($q->field_name), 'support') => 'support',
                            default => 'original',
                        };

                        CheckerFile::create([
                            'checker_order_id' => $order->id,
                            'category' => $category,
                            'original_name' => $file->getClientOriginalName(),
                            'file_name' => basename($path),
                            'extension' => $file->getClientOriginalExtension(),
                            'mime_type' => $file->getMimeType(),
                            'file_size' => $file->getSize(),
                            'file_path' => $path,
                            'uploaded_by' => 'customer',
                        ]);

                        $filePaths[] = $path;
                    }

                    if (!empty($filePaths)) {
                        CheckerAnswer::create([
                            'checker_order_id' => $order->id,
                            'checker_question_id' => $q->id,
                            'answer' => json_encode($filePaths), 
                        ]);
                    }
                }
            }

            // 5. Save Text/Textarea/Checkbox Answers
            foreach ($this->questions as $q) {
                if ($q->field_type !== 'file') {
                    if (isset($this->answers[$q->id]) && $this->answers[$q->id] !== '') {
                        CheckerAnswer::create([
                            'checker_order_id' => $order->id,
                            'checker_question_id' => $q->id,
                            'answer' => is_array($this->answers[$q->id]) ? json_encode($this->answers[$q->id]) : $this->answers[$q->id],
                        ]);
                    }
                }
            }

            // 6. Create Status Log
            CheckerStatusLog::create([
                'checker_order_id' => $order->id,
                'status' => 'waiting_payment',
                'description' => 'Pesanan baru dibuat oleh customer.',
                'changed_by' => 'system'
            ]);

            if ($this->use_token) {
                // Update log for token payment
                CheckerStatusLog::create([
                    'checker_order_id' => $order->id,
                    'status' => 'paid',
                    'description' => 'Pembayaran lunas menggunakan Token. Pesanan siap dikerjakan.',
                    'changed_by' => 'system'
                ]);

                // Update paid_at equivalent for token (using completed_at or custom if needed)
                $order->payments()->create([
                    'payment_method_id' => null, // No specific gateway method
                    'transaction_code' => 'TKN-USE-' . Str::random(5),
                    'gateway' => 'token',
                    'amount' => 0,
                    'admin_fee' => 0,
                    'total_amount' => 0,
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                    'expired_at' => now(),
                ]);

                DB::commit();
                
                // Redirect directly to track page
                return redirect()->route('checker.track.detail', ['invoice' => $invoice]);
            }

            // payment method (Tokopay)
            $qris = PaymentMetods::where('name', 'QRIS')->first();

            if($qris) {
                $order->payment_method_id = $qris->id;
                $order->save();
                
                $order->payments()->create([
                    'payment_method_id' => $qris->id,
                    'transaction_code' => Str::random(10),
                    'amount' => $this->totalPrice,
                    'admin_fee' => 0,
                    'total_amount' => $this->totalPrice,
                    'payment_status' => 'pending',
                    'paid_at' => null,
                    'expired_at' => now()->addMinutes(10),
                ]);
            }

            DB::commit();

            // 7. Redirect to Checkout (Payment Gateway)
            return redirect()->route('checker.payment', ['invoice' => $invoice]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('submit', 'Gagal memproses pesanan: ' . $e->getMessage());
            return;
        }
    }

    public function render()
    {
        return view('livewire.checker.service-form');
    }
}
