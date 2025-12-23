<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseService
{
    abstract protected function repository();

    public function all(): Collection
    {
        return $this->repository()->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository()->paginate($perPage);
    }

    public function findOrFail(int $id): Model
    {
        $model = $this->repository()->find($id);

        if (!$model) {
            throw new ModelNotFoundException();
        }

        return $model;
    }

    public function create(array $data): Model
    {
        return $this->repository()->create($data);
    }

    public function update(int $id, array $data): Model
    {
        $model = $this->findOrFail($id);
        return $this->repository()->update($model, $data);
    }

    public function delete(int $id): bool
    {
        $model = $this->findOrFail($id);
        return $this->repository()->delete($model);
    }
}
