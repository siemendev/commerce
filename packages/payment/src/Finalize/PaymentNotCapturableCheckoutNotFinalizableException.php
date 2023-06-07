<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Finalize;

use Siemendev\Checkout\Finalize\CheckoutNotFinalizableException;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;

class PaymentNotCapturableCheckoutNotFinalizableException extends CheckoutNotFinalizableException
{
    public function __construct(PaymentNotCapturableException $exception)
    {
        parent::__construct(message: 'Payment not capturable: ' . $exception->getMessage(), previous: $exception);
    }
}
