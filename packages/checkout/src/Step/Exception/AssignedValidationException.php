<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Exception;

use Exception;
use Siemendev\Checkout\Step\StepInterface;

class AssignedValidationException extends Exception
{
    public function __construct(
        ValidationException $exception,
        public readonly StepInterface $step,
    ) {
        parent::__construct($exception->getMessage(), 0, $exception);
    }
}
