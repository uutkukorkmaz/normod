<?php

namespace App\Providers;

use App\Repositories\Contracts\CustomerRepository;
use App\Repositories\Eloquent\CustomerRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        // Bind the implementation of the repository interface to the repository class itself. eg:
        // $this->app->bind(RepositoryInterface, RepositoryImplementation)

        $this->app->bind(
            CustomerRepository::class,
            CustomerRepositoryEloquent::class
        );
    }

}
