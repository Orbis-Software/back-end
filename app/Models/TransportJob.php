<?php

namespace App\Models;

use App\Enums\JobType;
use App\Enums\TransportMode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransportJob extends Model
{
    protected $table = 'transport_jobs';

    protected $fillable = [
        'company_id',
        'customer_id',
        'account_number',
        'customer',
        'quote_ref',
        'job_number',
        'job_date',
        'mode_of_transport',
        'job_type',
    ];

    protected $casts = [
        'job_date' => 'date',
        'mode_of_transport' => TransportMode::class,
        'job_type' => JobType::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function customerContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }
}
