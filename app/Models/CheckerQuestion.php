<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckerQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'checker_service_id',
        'label',
        'field_name',
        'validation',
        'help_text',
        'field_type',
        'placeholder',
        'is_required',
        'pricing_rule',
        'unit_price',
        'affects_price',
        'sort_order',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'affects_price' => 'boolean',
        'unit_price' => 'decimal:2',
    ];

    public function service()
    {
        return $this->belongsTo(CheckerService::class, 'checker_service_id');
    }

    public function options()
    {
        return $this->hasMany(CheckerQuestionOption::class);
    }
}
