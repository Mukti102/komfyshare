<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function costumer()
    {
        return $this->belongsTo(Costumer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productPrice()
    {
        return $this->belongsTo(ProductPrice::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMetods::class, 'payment_metod_id');
    }


    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];
}
