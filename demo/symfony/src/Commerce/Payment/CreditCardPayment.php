<?php declare(strict_types=1);

namespace App\Commerce\Payment;

use Siemendev\Checkout\Payment\Payment\Payment;

class CreditCardPayment extends Payment
{
    public string $cardNumber;

    public string $cardHolder;

    public int $cardExpiryMonth;

    public int $cardExpiryYear;

    public string $cardCsc;
}
