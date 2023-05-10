<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Exception;

use Siemendev\Checkout\Step\StepInterface;

class PreviousStepValidationException extends ValidationException
{
    public function __construct(public readonly StepInterface $previousStep)
    {
        parent::__construct('Previous step is not valid');
    }
}
