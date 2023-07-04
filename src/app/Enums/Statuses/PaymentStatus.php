<?php

namespace App\Enums\Statuses;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case NotSufficientFunds = 'err__not_sufficient_funds';
    case FraudSuspect = 'err__fraud_suspect';
    case ThreeDFail = 'err_3d_fail';
    case StolenCard = 'err__stolen_card';
    case Refunded = 'refunded';
    case RefundPending = 'refund_pending';

    public static function failCases()
    {
        return [
          self::NotSufficientFunds,
          self::FraudSuspect,
          self::ThreeDFail,
          self::StolenCard
        ];
    }

}

