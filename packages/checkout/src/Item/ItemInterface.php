<?php declare(strict_types=1);

namespace Siemendev\Checkout\Item;

use Siemendev\Checkout\Step\StepInterface;

interface ItemInterface
{
    /**
     * @return array<class-string<StepInterface>>
     */
    public function requiresSteps(): array;

    public function getItemIdentifier(): string;
}
