<?php

namespace App\Services;

use App\Models\Job;
use App\Models\JobRevenueLine;
use App\Enums\JobStatus;
use App\Repositories\Contracts\JobRevenueRepositoryInterface;
use Illuminate\Support\Collection;
use RuntimeException;

class JobRevenueService extends BaseService
{
    protected JobRevenueRepositoryInterface $repository;

    public function __construct(JobRevenueRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function repository(): JobRevenueRepositoryInterface
    {
        return $this->repository;
    }

    public function listByJob(Job $job): Collection
    {
        return $this->repository->getByJob($job->id);
    }

    public function createForJob(Job $job, array $data): JobRevenueLine
    {
        $this->guardJobEditable($job);

        $data['job_id'] = $job->id;

        return $this->repository->create($data);
    }

    public function updateRevenue(int $id, Job $job, array $data): JobRevenueLine
    {
        $this->guardJobEditable($job);

        $revenue = $this->findOrFail($id);

        return $this->repository->update($revenue, $data);
    }

    public function deleteRevenue(int $id, Job $job): bool
    {
        $this->guardJobEditable($job);

        $revenue = $this->findOrFail($id);

        return $this->repository->delete($revenue);
    }

    protected function guardJobEditable(Job $job): void
    {
        if ($job->status === JobStatus::Completed) {
            throw new RuntimeException('Revenue cannot be modified after job completion.');
        }
    }
}
