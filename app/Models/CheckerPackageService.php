<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckerPackageService extends Model
{
    use HasFactory;

    protected $fillable = [
        'checker_package_id',
        'checker_service_id',
        'token_cost'
    ];

    public function package()
    {
        return $this->belongsTo(CheckerPackage::class, 'checker_package_id');
    }

    public function service()
    {
        return $this->belongsTo(CheckerService::class, 'checker_service_id');
    }
}
