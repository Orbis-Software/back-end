<?php

namespace App\Repositories\Contracts;

use App\Models\JobAdjustmentLine;
use Illuminate\Support\Collection;

interface JobAdjustmentRepositoryInterface extends BaseRepositoryInterface
{
    public function getByJob(int $jobId): Collection;
}
