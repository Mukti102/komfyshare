<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerTestimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'university',
        'logo',
        'message',
        'is_active',
    ];
}
