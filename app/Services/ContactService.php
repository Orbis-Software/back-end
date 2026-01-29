<?php

namespace App\Services;

use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

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

    public function createWithTypes(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $types = $data['contact_types'] ?? [];
            unset($data['contact_types']);

            $contact = $this->contacts->create($data);

            foreach ($types as $type) {
                $contact->types()->create([
                    'contact_type' => $type,
                ]);
            }

            return $contact->load(['people', 'types']);
        });
    }

    public function updateWithTypes(int $id, array $data): Model
    {
        return DB::transaction(function () use ($id, $data) {
            $typesProvided = array_key_exists('contact_types', $data);
            $types = $data['contact_types'] ?? [];
            unset($data['contact_types']);

            $contact = $this->update($id, $data);

            if ($typesProvided) {
                $contact->types()->delete();

                foreach ($types as $type) {
                    $contact->types()->create([
                        'contact_type' => $type,
                    ]);
                }
            }

            return $contact->load(['people', 'types']);
        });
    }
}
