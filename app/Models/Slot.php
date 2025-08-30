<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $guarded = ['id'];

    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function costumer(){
        return $this->belongsTo(Costumer::class);
    }
}
