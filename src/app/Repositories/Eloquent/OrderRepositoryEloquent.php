<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Criteria\Customer\OnlyCanAccessOwnedResourcesCriteriaCriteria;
use App\Criteria\Order\FilterCriteria;
use App\Enums\Statuses\OrderStatus;
use App\Models\Order;
use App\Repositories\Contracts\OrderRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

final class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{

    protected $fieldSearchable = [
        'status',
        'id' => 'like',
        'invoice_number' => 'like'
    ];

    public function model()
    {
        return Order::class;
    }

    public function onlyPaid()
    {
        return $this->where('status', '!=', OrderStatus::PAYMENT_PENDING)->get();
    }


    public function getTotalAmount(Order $order): int
    {
        return $order->items()
            ->select(['unit_amount', 'quantity'])
            ->get()
            ->map(fn($item) => intval($item->unit_amount->getAmount()) * $item->quantity)->sum();
    }

    public function getOrdersByCustomerId(string $customer_id): LengthAwarePaginator
    {
//        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(FilterCriteria::class);
        $this->pushCriteria(OnlyCanAccessOwnedResourcesCriteriaCriteria::class);

        return $this->paginate();
    }

}
