<?php

namespace App\Services;

use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactService extends BaseService
{
    public function __construct(protected ContactRepositoryInterface $contacts) {}

    protected function repository(): ContactRepositoryInterface
    {
        return $this->contacts;
    }

    public function paginateFiltered(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->contacts->paginateFiltered($filters, $perPage);
    }
}
