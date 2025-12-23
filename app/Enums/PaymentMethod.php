<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Stripe = 'stripe';
    case Paypal = 'paypal';
    case BankTransfer = 'bank_transfer';
    case Cash = 'cash';
}
