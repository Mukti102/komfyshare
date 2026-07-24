<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckerPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'checker_order_id',
        'payment_method_id',
        'transaction_code',
        'gateway',
        'amount',
        'admin_fee',
        'total_amount',
        'payment_status',
        'paid_at',
        'expired_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(CheckerOrder::class, 'checker_order_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMetods::class, 'payment_method_id');
    }

    public function logs()
    {
        return $this->hasMany(CheckerPaymentLog::class);
    }
}
