<?php

namespace App\Repositories\Contracts;

use App\Models\JobRevenueLine;
use Illuminate\Support\Collection;

interface JobRevenueRepositoryInterface extends BaseRepositoryInterface
{
    public function getByJob(int $jobId): Collection;
}
