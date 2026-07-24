<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerQuestionOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'checker_question_id',
        'label',
        'value',
        'additional_price',
        'sort_order'
    ];

    protected $casts = [
        'additional_price' => 'decimal:2',
    ];

    public function question()
    {
        return $this->belongsTo(CheckerQuestion::class, 'checker_question_id');
    }
}
