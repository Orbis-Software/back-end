<?php

namespace App\Services;

use App\Models\Job;
use App\Models\JobCostLine;
use App\Enums\JobStatus;
use App\Repositories\Contracts\JobCostRepositoryInterface;
use Illuminate\Support\Collection;
use RuntimeException;

class JobCostService extends BaseService
{
    protected JobCostRepositoryInterface $repository;

    public function __construct(JobCostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function repository(): JobCostRepositoryInterface
    {
        return $this->repository;
    }

    public function listByJob(Job $job): Collection
    {
        return $this->repository->getByJob($job->id);
    }

    public function createForJob(Job $job, array $data): JobCostLine
    {
        $this->guardJobEditable($job);

        $data['job_id'] = $job->id;

        return $this->repository->create($data);
    }

    public function updateCost(int $id, Job $job, array $data): JobCostLine
    {
        $this->guardJobEditable($job);

        $cost = $this->findOrFail($id);

        return $this->repository->update($cost, $data);
    }

    public function deleteCost(int $id, Job $job): bool
    {
        $this->guardJobEditable($job);

        $cost = $this->findOrFail($id);

        return $this->repository->delete($cost);
    }

    protected function guardJobEditable(Job $job): void
    {
        if ($job->status === JobStatus::Completed) {
            throw new RuntimeException('Costs cannot be modified after job completion.');
        }
    }
}
