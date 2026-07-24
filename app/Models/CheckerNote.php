<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'checker_order_id',
        'note',
        'created_by'
    ];

    public function order()
    {
        return $this->belongsTo(CheckerOrder::class, 'checker_order_id');
    }
}
