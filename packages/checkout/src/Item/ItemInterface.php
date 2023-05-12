<?php declare(strict_types=1);

namespace Siemendev\Checkout\Item;

interface ItemInterface
{
    /**
     * returns an array of step identifiers that are required for this item.
     * @see \Siemendev\Checkout\Step\StepInterface::stepIdentifier()
     * @return array<string>
     */
    public function requiresSteps(): array;

    /**
     * returns a unique identifier for this item
     */
    public function getItemIdentifier(): string;
}
