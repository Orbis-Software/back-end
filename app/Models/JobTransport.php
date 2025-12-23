<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\TransportMode;
use App\Enums\TransportStatus;

class JobTransport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'job_id',
        'transport_mode',
        'sequence',
        'origin',
        'destination',
        'status',
    ];

    protected $casts = [
        'transport_mode' => TransportMode::class,
        'status' => TransportStatus::class,
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
