<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckerPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'total_token',
        'expired_day',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function packageServices()
    {
        return $this->hasMany(CheckerPackageService::class);
    }

    public function services()
    {
        return $this->belongsToMany(CheckerService::class, 'checker_package_services');
    }
}
