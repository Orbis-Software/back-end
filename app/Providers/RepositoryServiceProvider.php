<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\ContactRepositoryInterface;
use App\Repositories\Contracts\ContactPersonRepositoryInterface;
use App\Repositories\Contracts\TransportJobRepositoryInterface;

use App\Repositories\UserRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ContactRepository;
use App\Repositories\ContactPersonRepository;
use App\Repositories\TransportJobRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(ContactPersonRepositoryInterface::class, ContactPersonRepository::class);
        $this->app->bind(TransportJobRepositoryInterface::class, TransportJobRepository::class);
    }
}
