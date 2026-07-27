<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerTokenWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'checker_package_id',
        'total_token',
        'expired_at'
    ];
    
    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Costumer::class, 'customer_id');
    }

    public function package()
    {
        return $this->belongsTo(CheckerPackage::class, 'checker_package_id');
    }

    public function histories()
    {
        return $this->hasMany(CheckerTokenHistory::class);
    }
    
    public function scopeActive($query)
    {
        return $query->where('expired_at', '>', now())
                     ->orWhereNull('expired_at');
    }
}
