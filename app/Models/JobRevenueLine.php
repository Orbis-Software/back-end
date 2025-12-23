<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobRevenueLine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'job_id',
        'description',
        'amount',
        'currency',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
