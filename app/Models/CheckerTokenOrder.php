<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerTokenOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'checker_package_id',
        'payment_method_id',
        'total_price',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Costumer::class, 'customer_id');
    }

    public function package()
    {
        return $this->belongsTo(CheckerPackage::class, 'checker_package_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMetods::class, 'payment_method_id');
    }
}
