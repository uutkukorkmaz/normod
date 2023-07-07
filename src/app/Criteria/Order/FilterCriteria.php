<?php

namespace App\Criteria\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Http\Resources\MissingValue;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class FilterCriteriaCriteria.
 *
 * @package namespace App\Criteria\Order;
 */
class FilterCriteria implements CriteriaInterface
{
    use ConditionallyLoadsAttributes;

    /**
     * Apply criteria in query repository
     *
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $request = request();

        if (!class_implements($repository, RepositoryCriteriaInterface::class)) {
            throw new \RuntimeException(
                "The repository [" . get_class($repository) . "] should implement " . RepositoryCriteriaInterface::class
            );
        }

        if ($request->has('filterBy')) {
            $request->merge($this->filter(['search' => $request->input('filterBy'), 'filterBy' => new MissingValue()]));
        }


        return (new RequestCriteria($request))->apply($model,$repository);
    }
}
