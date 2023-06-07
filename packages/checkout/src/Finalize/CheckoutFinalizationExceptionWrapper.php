<?php declare(strict_types=1);

namespace Siemendev\Checkout\Finalize;

use Exception;
use Throwable;

class CheckoutFinalizationExceptionWrapper extends Exception
{
    /**
     * @param array<FinalizationRollbackException> $rollbackExceptions
     */
    public function __construct(
        Throwable $exception,
        private readonly array $rollbackExceptions = [],
    ) {
        parent::__construct($exception->getMessage(), $exception->getCode(), previous: $exception);
    }

    /**
     * @return array<FinalizationRollbackException>
     */
    public function getRollbackExceptions(): array
    {
        return $this->rollbackExceptions;
    }
}
