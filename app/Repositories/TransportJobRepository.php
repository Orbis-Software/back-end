<?php

namespace App\Repositories;

use App\Models\TransportJob;
use App\Repositories\Contracts\TransportJobRepositoryInterface;

class TransportJobRepository extends BaseRepository implements TransportJobRepositoryInterface
{
    public function __construct(TransportJob $model)
    {
        $this->model = $model;
    }

    public function findByJobNumber(string $jobNumber): ?TransportJob
    {
        return $this->model->newQuery()->where('job_number', $jobNumber)->first();
    }

    public function existsJobNumber(string $jobNumber, ?int $ignoreId = null): bool
    {
        $q = $this->model->newQuery()->where('job_number', $jobNumber);
        if ($ignoreId) {
            $q->where('id', '!=', $ignoreId);
        }
        return $q->exists();
    }
}
