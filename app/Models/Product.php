<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'listOfBenefits' => 'array',
    ];


    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
