<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerTokenWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_token'
    ];

    public function customer()
    {
        return $this->belongsTo(Costumer::class, 'customer_id');
    }

    public function histories()
    {
        return $this->hasMany(CheckerTokenHistory::class);
    }
}
