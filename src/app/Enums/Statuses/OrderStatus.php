<?php

namespace App\Enums\Statuses;

/**
 * @case PAYMENT_PENDING
 * @case INVOICED
 * @case PRODUCING
 * @case PREPARING
 * @case SHIPPED_OUT
 * @case DELIVERED
 * @case CANCELLED
 * @case RETURNED
 *
 * @default PAYMENT_PENDING
 */
enum OrderStatus: string
{
    case PAYMENT_PENDING = 'payment_pending';
	case INVOICED = 'invoiced';
	case PRODUCING = 'producing';
	case PREPARING = 'preparing';
	case SHIPPED_OUT = 'shipped_out';
	case DELIVERED = 'delivered';
	case CANCELLED = 'cancelled';
	case RETURNED = 'returned';

}

