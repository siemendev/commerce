<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Finalize;

use Siemendev\Checkout\Finalize\CheckoutNotFinalizableException;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;

class PaymentNotCapturableCheckoutNotFinalizableException extends CheckoutNotFinalizableException
{
    /**
     * @param array<PaymentCaptureRollbackException> $rollbackExceptions
     */
    public function __construct(PaymentNotCapturableException $exception, private readonly array $rollbackExceptions)
    {
        parent::__construct(message: 'Payment not capturable: ' . $exception->getMessage(), previous: $exception);
    }

    /**
     * @return array<PaymentCaptureRollbackException>
     */
    public function getRollbackExceptions(): array
    {
        return $this->rollbackExceptions;
    }
}
