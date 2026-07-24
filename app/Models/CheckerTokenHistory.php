<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerTokenHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'checker_token_wallet_id',
        'checker_order_id',
        'checker_package_id',
        'type',
        'token',
        'balance_before',
        'balance_after',
        'description'
    ];

    public function wallet()
    {
        return $this->belongsTo(CheckerTokenWallet::class, 'checker_token_wallet_id');
    }

    public function order()
    {
        return $this->belongsTo(CheckerOrder::class, 'checker_order_id');
    }

    public function package()
    {
        return $this->belongsTo(CheckerPackage::class, 'checker_package_id');
    }
}
