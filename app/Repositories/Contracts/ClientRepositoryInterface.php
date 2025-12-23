<?php

namespace App\Repositories\Contracts;

use App\Models\Client;

interface ClientRepositoryInterface extends BaseRepositoryInterface
{
    public function findByUserId(int $userId): ?Client;
}
