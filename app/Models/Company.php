<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'legal_name',
        'trading_name',
        'registration_number',
        'registered_address',
        'operational_address',
        'default_currency',
        'time_zone',
        'status',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function transportJobs(): HasMany
    {
        return $this->hasMany(TransportJob::class);
    }
}
