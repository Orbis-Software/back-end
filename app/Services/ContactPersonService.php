<?php

namespace App\Services;

use App\Repositories\Contracts\ContactPersonRepositoryInterface;

class ContactPersonService extends BaseService
{
    public function __construct(protected ContactPersonRepositoryInterface $people) {}

    protected function repository(): ContactPersonRepositoryInterface
    {
        return $this->people;
    }
}
