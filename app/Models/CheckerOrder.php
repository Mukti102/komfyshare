<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CheckerOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::deleting(function ($order) {
            if ($order->isForceDeleting()) {
                $order->files()->withTrashed()->get()->each->forceDelete();
                $order->answers()->delete();
                $order->statusLogs()->delete();
                if ($order->payment) {
                    $order->payment()->delete();
                }
            } else {
                $order->files()->delete();
            }
        });
    }

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'checker_service_id',
        'checker_package_id',
        'payment_method_id',
        'payment_type',
        'total_price',
        'token_used',
        'notes',
        'status',
        'estimated_finish',
        'completed_at'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'estimated_finish' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected function formattedTotalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->total_price, 0, ',', '.'),
        );
    }

    public function customer()
    {
        return $this->belongsTo(Costumer::class, 'customer_id');
    }

    public function service()
    {
        return $this->belongsTo(CheckerService::class, 'checker_service_id');
    }

    public function package()
    {
        return $this->belongsTo(CheckerPackage::class, 'checker_package_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMetods::class, 'payment_method_id');
    }

    public function answers()
    {
        return $this->hasMany(CheckerAnswer::class);
    }

    public function textAnswers()
    {
        return $this->hasMany(CheckerAnswer::class)->whereHas('question', function($q) {
            $q->where('field_type', '!=', 'file');
        });
    }

    public function files()
    {
        return $this->hasMany(CheckerFile::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(CheckerStatusLog::class);
    }

    public function assignments()
    {
        return $this->hasMany(CheckerAssignment::class);
    }

    public function downloadHistories()
    {
        return $this->hasMany(CheckerDownloadHistory::class);
    }

    public function notes()
    {
        return $this->hasMany(CheckerNote::class);
    }

    public function payments()
    {
        return $this->hasMany(CheckerPayment::class);
    }
}
