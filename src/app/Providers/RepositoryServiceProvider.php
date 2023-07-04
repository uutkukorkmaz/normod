<?php

namespace App\Providers;

use App\Repositories\Contracts\CustomerRepository;
use App\Repositories\Contracts\OrderRepository;
use App\Repositories\Eloquent\CustomerRepositoryEloquent;
use App\Repositories\Eloquent\OrderRepositoryEloquent;
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

        $this->app->bind(
            OrderRepository::class,
            OrderRepositoryEloquent::class
        );
    }

}
