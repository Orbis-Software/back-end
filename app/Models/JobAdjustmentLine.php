<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobAdjustmentLine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'job_id',
        'type',
        'description',
        'amount_delta',
        'currency',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
