<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Finalize;

use Siemendev\Checkout\Finalize\FinalizationRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;

class PaymentsRollbackExceptionsCollection extends FinalizationRollbackException
{
    /**
     * @param array<PaymentCaptureRollbackException> $exceptions
     */
    public function __construct(public readonly array $exceptions)
    {
        parent::__construct(message: 'At least one exception has happened during payments rollback.', previous: array_values($exceptions)[0]);
    }

    /**
     * @return array<PaymentCaptureRollbackException>
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
