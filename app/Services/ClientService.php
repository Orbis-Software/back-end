<?php

namespace App\Services;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;

class ClientService extends BaseService
{
    protected ClientRepositoryInterface $repository;

    public function __construct(ClientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function repository(): ClientRepositoryInterface
    {
        return $this->repository;
    }

    public function getByUser(int $userId): ?Client
    {
        return $this->repository->findByUserId($userId);
    }

    public function createForUser(int $userId, array $data): Client
    {
        $data['user_id'] = $userId;

        return $this->repository->create($data);
    }
}
