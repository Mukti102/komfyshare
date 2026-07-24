<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'checker_order_id',
        'status',
        'description',
        'changed_by'
    ];

    public function order()
    {
        return $this->belongsTo(CheckerOrder::class, 'checker_order_id');
    }
}
