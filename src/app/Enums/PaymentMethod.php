<?php

namespace App\Enums;

enum PaymentMethod: string
{

    case DirectPaymentWithCreditCard = 'direct_cc';
    case ThreeDSecuredPaymentWithCreditCard = '3ds_cc';
    case APM_Wallet = 'wallet';
    case APM_Gateway = 'gateway';
    case APM_ShoppingLoan = 'loan';


}
