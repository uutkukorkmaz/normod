<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepository;
use Prettus\Repository\Eloquent\BaseRepository;

final class CustomerRepositoryEloquent extends BaseRepository implements CustomerRepository
{

    public function model()
    {
        return Customer::class;
    }


}
