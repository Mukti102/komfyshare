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
        
        if ($customer) {
            $this->customer_name = $customer->name;
            $this->whatsapp_check_status = 'found';
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
    return app(PricingService::class)->calculate(
        service: $this->service,
        answers: $this->answers,
        uploads: $this->document_files,
    );
}

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'customer_name' => 'required|string|max:255',
                'customer_whatsapp' => 'required|string|max:20',
            ]);
        } elseif ($this->step === 2) {
            $rules = [];
            foreach ($this->questions as $q) {
                if ($q->is_required) {
                    if ($q->field_type === 'file') {
                        $rules['document_files.' . $q->id] = 'required|array|min:1'; 
                        $rules['document_files.' . $q->id . '.*'] = 'file|max:10240';
                    } elseif ($q->field_type === 'checkbox') {
                        // optional
                    } else {
                        $rules['answers.' . $q->id] = 'required';
                    }
                }
            }
            $this->validate($rules);
        }

        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function submit()
    {
        DB::beginTransaction();

        try {
            // 1. Find or Create Customer
            $customer = Costumer::firstOrCreate(
                ['phone' => $this->customer_whatsapp],
                ['name' => $this->customer_name]
            );

            // 2. Generate Invoice Number
            $invoice = 'CHK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // 3. Create Order
            $order = CheckerOrder::create([
                'invoice_number' => $invoice,
                'customer_id' => $customer->id,
                'checker_service_id' => $this->service->id,
                'payment_type' => 'midtrans', 
                'total_price' => $this->totalPrice, 
                'status' => 'waiting_payment',
            ]);

            // 4. Save Files
            foreach ($this->questions as $q) {
                if ($q->field_type === 'file' && !empty($this->document_files[$q->id])) {
                    $filePaths = [];
                    foreach ($this->document_files[$q->id] as $file) {
                        $path = $file->store('checker_files', 'public');
                        
                        CheckerFile::create([
                            'checker_order_id' => $order->id,
                            'category' => $q->field_name, // Using field name to distinguish between files
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
                'status' => 'pending',
                'notes' => 'Pesanan baru dibuat oleh customer.',
                'created_by' => 'system'
            ]);


            // payment method 
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

            // 7. Redirect to Checkout
            return redirect()->route('checker.checkout', ['invoice' => $invoice]);

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
