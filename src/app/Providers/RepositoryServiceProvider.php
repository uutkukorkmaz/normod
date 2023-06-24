<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        // Bind the implementation of the repository interface to the repository class itself. eg:
        // $this->app->bind(RepositoryInterface, RepositoryImplementation)
    }

}
