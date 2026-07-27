<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckerFile extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        $deleteFile = function ($checkerFile) {
            if ($checkerFile->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($checkerFile->file_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($checkerFile->file_path);
            }
        };

        static::deleted($deleteFile);
        static::forceDeleted($deleteFile);
    }

    protected $fillable = [
        'checker_order_id',
        'category',
        'original_name',
        'file_name',
        'extension',
        'mime_type',
        'file_size',
        'file_path',
        'uploaded_by',
        'uploaded_at',
        'expired_at'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(CheckerOrder::class, 'checker_order_id');
    }
}
