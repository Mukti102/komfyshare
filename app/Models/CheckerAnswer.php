<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'checker_order_id',
        'checker_question_id',
        'answer'
    ];

    public function order()
    {
        return $this->belongsTo(CheckerOrder::class, 'checker_order_id');
    }

    public function question()
    {
        return $this->belongsTo(CheckerQuestion::class, 'checker_question_id');
    }
}
