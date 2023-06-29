<?php

namespace App\Criteria\Customer;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OnlyCanAccessOwnedResourcesCriteriaCriteria.
 *
 * @package namespace App\Criteria\Customer;
 */
class OnlyCanAccessOwnedResourcesCriteriaCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /**
         * DEVELOPER'S NOTE:
         * For demonstration purposes, assuming that bearer token is the customer uuid
         */
        return $model->where('customer_id', '=', request()->bearerToken());
    }

}
