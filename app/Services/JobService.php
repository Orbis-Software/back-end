<?php

namespace App\Services;

use App\Models\Job;
use App\Enums\JobStatus;
use App\Repositories\Contracts\JobRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class JobService extends BaseService
{
    protected JobRepositoryInterface $repository;

    public function __construct(JobRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function repository(): JobRepositoryInterface
    {
        return $this->repository;
    }

    /**
     * Create a job with auto-generated reference.
     */
    public function create(array $data): Job
    {
        return DB::transaction(function () use ($data) {
            $data['job_reference'] = $this->generateJobReference();
            $data['status'] = JobStatus::Draft;

            return $this->repository->create($data);
        });
    }

    /**
     * Update job details only if job is not completed.
     */
    public function update(int $id, array $data): Job
    {
        $job = $this->findOrFail($id);

        $this->guardNotCompleted($job);

        return $this->repository->update($job, $data);
    }

    /**
     * Transition job status.
     */
    public function updateStatus(int $id, JobStatus $status): Job
    {
        $job = $this->findOrFail($id);

        if ($job->status === JobStatus::Completed) {
            throw new RuntimeException('Completed jobs cannot change status.');
        }

        if ($status === JobStatus::Completed) {
            $job->completed_at = now();
        }

        return $this->repository->update($job, [
            'status' => $status,
            'completed_at' => $job->completed_at,
        ]);
    }

    /**
     * List jobs with client info.
     */
    public function list(int $perPage = 15)
    {
        return $this->repository->paginateWithClient($perPage);
    }

    /**
     * Load job with all financial data.
     */
    public function getWithFinancials(int $id): Job
    {
        $job = $this->findOrFail($id);

        return $this->repository->loadFinancials($job);
    }

    /**
     * Calculate total costs.
     */
    public function totalCosts(Job $job): float
    {
        return $job->costLines->sum('amount');
    }

    /**
     * Calculate total revenue.
     */
    public function totalRevenue(Job $job): float
    {
        return $job->revenueLines->sum('amount');
    }

    /**
     * Calculate total adjustments.
     */
    public function totalAdjustments(Job $job): float
    {
        return $job->adjustmentLines->sum('amount_delta');
    }

    /**
     * Calculate gross profit including adjustments.
     */
    public function grossProfitWithAdjustments(Job $job): float
    {
        return
            $this->totalRevenue($job)
            - $this->totalCosts($job)
            + $this->totalAdjustments($job);
    }

    /**
     * Prevent modifications when job is completed.
     */
    protected function guardNotCompleted(Job $job): void
    {
        if ($job->status === JobStatus::Completed) {
            throw new RuntimeException('Completed jobs cannot be modified.');
        }
    }

    /**
     * Generate a readable job reference.
     */
    protected function generateJobReference(): string
    {
        $prefix = 'JOB-' . now()->format('Y');

        $lastJob = $this->repository->findLastByReferencePrefix($prefix);

        $nextNumber = 1;

        if ($lastJob) {
            $lastNumber = (int) substr($lastJob->job_reference, -5);
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . '-' . str_pad((string) $nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
