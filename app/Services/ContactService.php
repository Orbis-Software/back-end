<?php

namespace App\Services;

use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function findWithPeopleOrFail(int $id): Model
    {
        $model = $this->contacts->findWithPeople($id);

        if (!$model) {
            throw new ModelNotFoundException();
        }

        return $model;
    }
}
