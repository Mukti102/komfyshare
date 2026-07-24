<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'checker_order_id',
        'title',
        'message',
        'channel',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Costumer::class, 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo(CheckerOrder::class, 'checker_order_id');
    }
}
