<?php

namespace App\Enums\Statuses;

enum ShippingStatus: string
{
    case ShippedOut = 'shipped_out';
    case Distributing = 'distributing';
    case Delivered = 'delivered';
    case RejectedByCustomer = 'rejected_by_customer';
    case Lost = 'lost';

}

