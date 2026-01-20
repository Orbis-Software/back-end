<?php

namespace App\Repositories\Contracts;

use App\Models\TransportJob;

interface TransportJobRepositoryInterface extends BaseRepositoryInterface
{
    public function findByJobNumber(string $jobNumber): ?TransportJob;
    public function existsJobNumber(string $jobNumber, ?int $ignoreId = null): bool;
}
