<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'name',
    ];

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
