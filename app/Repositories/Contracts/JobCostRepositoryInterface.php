<?php

namespace App\Repositories\Contracts;

use App\Models\JobCostLine;
use Illuminate\Support\Collection;

interface JobCostRepositoryInterface extends BaseRepositoryInterface
{
    public function getByJob(int $jobId): Collection;
}
