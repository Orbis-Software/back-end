<?php

namespace App\Repositories;

use App\Models\ContactPerson;
use App\Repositories\Contracts\ContactPersonRepositoryInterface;

class ContactPersonRepository extends BaseRepository implements ContactPersonRepositoryInterface
{
    public function __construct(ContactPerson $model)
    {
        $this->model = $model;
    }
}
