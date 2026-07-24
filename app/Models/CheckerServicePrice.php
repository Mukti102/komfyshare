<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerServicePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'checker_service_id',
        'pricing_type',
        'minimum_price',
        'maximum_price'
    ];

    protected $casts = [
        'minimum_price' => 'decimal:2',
        'maximum_price' => 'decimal:2',
    ];

    public function service()
    {
        return $this->belongsTo(CheckerService::class, 'checker_service_id');
    }
}
