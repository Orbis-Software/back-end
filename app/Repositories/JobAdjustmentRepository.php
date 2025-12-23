<?php

namespace App\Repositories;

use App\Models\JobAdjustmentLine;
use App\Repositories\Contracts\JobAdjustmentRepositoryInterface;
use Illuminate\Support\Collection;

class JobAdjustmentRepository extends BaseRepository implements JobAdjustmentRepositoryInterface
{
    public function __construct(JobAdjustmentLine $model)
    {
        $this->model = $model;
    }

    public function getByJob(int $jobId): Collection
    {
        return $this->model
            ->newQuery()
            ->where('job_id', $jobId)
            ->get();
    }
}
