<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\PayPal;


use Siemendev\Checkout\Payment\Payment\AbstractPayment;

class PayPalPayment extends AbstractPayment
{
    public static function getPaymentMethodIdentifier(): string
    {
        return 'paypal';
    }
}
