<?php

namespace App\Services;

use App\Models\Job;
use App\Models\JobAdjustmentLine;
use App\Repositories\Contracts\JobAdjustmentRepositoryInterface;
use Illuminate\Support\Collection;

class JobAdjustmentService extends BaseService
{
    protected JobAdjustmentRepositoryInterface $repository;

    public function __construct(JobAdjustmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function repository(): JobAdjustmentRepositoryInterface
    {
        return $this->repository;
    }

    public function listByJob(Job $job): Collection
    {
        return $this->repository->getByJob($job->id);
    }

    /**
     * Adjustments are always allowed, even if job is completed.
     * Adjustments are append-only.
     */
    public function createForJob(Job $job, array $data): JobAdjustmentLine
    {
        $data['job_id'] = $job->id;

        return $this->repository->create($data);
    }
}
