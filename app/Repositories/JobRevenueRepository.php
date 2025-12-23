<?php

namespace App\Repositories;

use App\Models\JobRevenueLine;
use App\Repositories\Contracts\JobRevenueRepositoryInterface;
use Illuminate\Support\Collection;

class JobRevenueRepository extends BaseRepository implements JobRevenueRepositoryInterface
{
    public function __construct(JobRevenueLine $model)
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
