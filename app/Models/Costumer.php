<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costumer extends Model
{
    protected $guarded = ['id'];

    public function Orders(){
        return $this->hasMany(Order::class);
    }
    
}
