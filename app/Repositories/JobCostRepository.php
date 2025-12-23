<?php

namespace App\Repositories;

use App\Models\JobCostLine;
use App\Repositories\Contracts\JobCostRepositoryInterface;
use Illuminate\Support\Collection;

class JobCostRepository extends BaseRepository implements JobCostRepositoryInterface
{
    public function __construct(JobCostLine $model)
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
