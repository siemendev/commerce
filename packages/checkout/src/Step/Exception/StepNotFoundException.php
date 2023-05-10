<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Exception;

use LogicException;

class StepNotFoundException extends LogicException
{
    public function __construct(public readonly string $stepIdentifier)
    {
        parent::__construct('Step not found');
    }
}
