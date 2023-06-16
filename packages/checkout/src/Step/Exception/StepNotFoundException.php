<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Step\Exception;

use LogicException;

class StepNotFoundException extends LogicException
{
    /**
     * @param array<string> $availableSteps
     */
    public function __construct(string $stepIdentifier, array $availableSteps = [])
    {
        parent::__construct(sprintf('Step "%s" not found. Available steps: %s', $stepIdentifier, implode(', ', $availableSteps)));
    }
}
