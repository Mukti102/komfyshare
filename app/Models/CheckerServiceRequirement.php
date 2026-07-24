<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerServiceRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'checker_service_id',
        'accepted_extension',
        'max_file_size',
        'max_upload',
        'allow_multiple'
    ];

    protected $casts = [
        'allow_multiple' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(CheckerService::class, 'checker_service_id');
    }
}
