<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Finalize;

use Siemendev\Checkout\Finalize\FinalizationRollbackException;

class PaymentsRollbackExceptionsCollection extends FinalizationRollbackException
{
    public function __construct(public readonly array $exceptions)
    {
        parent::__construct(message: 'At least one exception has happened during payments rollback.', previous: array_values($exceptions)[0]);
    }

    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
