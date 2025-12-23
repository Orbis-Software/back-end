<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;

class JobPayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'job_id',
        'payment_method',
        'amount',
        'currency',
        'external_reference',
        'status',
        'received_at',
    ];

    protected $casts = [
        'payment_method' => PaymentMethod::class,
        'status' => PaymentStatus::class,
        'received_at' => 'datetime',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
