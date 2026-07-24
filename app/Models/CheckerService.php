<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CheckerService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'price',
        'base_price',
        'estimated_hours',
        'is_token_available',
        'status',
        'sort_order',
        'color',
        'badge',
    ];

    protected $casts = [
        'is_token_available' => 'boolean',
        'status' => 'boolean',
        'price' => 'decimal:2',
        'base_price' => 'decimal:2',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    public function questions()
    {
        return $this->hasMany(CheckerQuestion::class);
    }

    public function prices()
    {
        return $this->hasMany(CheckerServicePrice::class);
    }

    public function requirements()
    {
        return $this->hasMany(CheckerServiceRequirement::class);
    }

    public function packageServices()
    {
        return $this->hasMany(CheckerPackageService::class);
    }

    public function packages()
    {
        return $this->belongsToMany(CheckerPackage::class, 'checker_package_services');
    }
}
