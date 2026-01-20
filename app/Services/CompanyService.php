<?php

namespace App\Services;

use App\Repositories\Contracts\CompanyRepositoryInterface;

class CompanyService extends BaseService
{
    public function __construct(protected CompanyRepositoryInterface $companies) {}

    protected function repository(): CompanyRepositoryInterface
    {
        return $this->companies;
    }
}
