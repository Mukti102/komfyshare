<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'stock',
        'sisa_stock',
        'percentase_discount',
        'rupiah_discount',
        'expired_date',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'expired_date' => 'date',
    ];
}
