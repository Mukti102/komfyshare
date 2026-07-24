<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerDownloadHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'checker_order_id',
        'customer_id',
        'downloaded_at',
        'ip_address',
        'device'
    ];

    protected $casts = [
        'downloaded_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(CheckerOrder::class, 'checker_order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Costumer::class, 'customer_id');
    }
}
