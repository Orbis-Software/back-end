<?php

namespace App\Services;

use App\Repositories\Contracts\TransportJobRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TransportJobService extends BaseService
{
    public function __construct(protected TransportJobRepositoryInterface $jobs) {}

    protected function repository(): TransportJobRepositoryInterface
    {
        return $this->jobs;
    }

    public function create(array $data): Model
    {
        if (!empty($data['job_number']) && $this->jobs->existsJobNumber($data['job_number'])) {
            throw new \InvalidArgumentException('job_number already exists.');
        }

        return parent::create($data);
    }

    public function update(int $id, array $data): Model
    {
        if (!empty($data['job_number']) && $this->jobs->existsJobNumber($data['job_number'], $id)) {
            throw new \InvalidArgumentException('job_number already exists.');
        }

        return parent::update($id, $data);
    }
}
