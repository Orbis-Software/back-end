<?php

namespace App\Repositories;

use App\Models\Job;
use App\Repositories\Contracts\JobRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class JobRepository extends BaseRepository implements JobRepositoryInterface
{
    public function __construct(Job $job)
    {
        $this->model = $job;
    }

    public function paginateWithClient(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->with('client')
            ->latest()
            ->paginate($perPage);
    }

    public function loadFinancials(Job $job): Job
    {
        return $job->load([
            'costLines',
            'revenueLines',
            'adjustmentLines',
        ]);
    }

    public function findLastByReferencePrefix(string $prefix): ?Job
    {
        return $this->model
            ->newQuery()
            ->where('job_reference', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();
    }

}
