<?php declare(strict_types=1);

namespace Siemendev\Checkout\Finalize;

use Exception;

class UnknownFinalizationStepException extends Exception
{
    /**
     * @param array<string> $availableSteps
     */
    public function __construct(CheckoutFinalizationHandlerInterface $handler, array $availableSteps)
    {
        parent::__construct(sprintf('Handler "%s" is loaded but requests execution in unknown finalization step "%s", available finalization steps are: %s', $handler::class, $handler->step(), implode(', ', $availableSteps)));
    }
}
