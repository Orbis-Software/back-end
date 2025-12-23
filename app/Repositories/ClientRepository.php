<?php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;

class ClientRepository extends BaseRepository implements ClientRepositoryInterface
{
    public function __construct(Client $client)
    {
        $this->model = $client;
    }

    public function findByUserId(int $userId): ?Client
    {
        return $this->model
            ->newQuery()
            ->where('user_id', $userId)
            ->first();
    }
}
