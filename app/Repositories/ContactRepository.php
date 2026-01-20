<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function __construct(Contact $model)
    {
        $this->model = $model;
    }

    public function paginateFiltered(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $q = $this->model->newQuery();

        if (!empty($filters['company_id'])) {
            $q->where('company_id', (int) $filters['company_id']);
        }

        if (!empty($filters['contact_type'])) {
            $q->where('contact_type', $filters['contact_type']);
        }

        // Optional: status filter
        if (!empty($filters['status'])) {
            $q->where('status', $filters['status']);
        }

        return $q->paginate($perPage);
    }
}
