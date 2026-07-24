<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerPaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'checker_payment_id',
        'status',
        'gateway_response'
    ];

    protected $casts = [
        'gateway_response' => 'array',
    ];

    public function payment()
    {
        return $this->belongsTo(CheckerPayment::class, 'checker_payment_id');
    }
}
