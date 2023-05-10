<?php declare(strict_types=1);

namespace App\Commerce;

use Siemendev\Checkout\Item\ItemInterface;
use Siemendev\Checkout\Item\QuantifiableItemInterface;
use Siemendev\Checkout\Step\StepInterface;

class Item implements ItemInterface, QuantifiableItemInterface
{
    public string $id;

    public string $name;

    /** @var array<class-string<StepInterface>> */
    public array $requiresSteps = [];

    public int $quantity = 1;

    public function requiresSteps(): array
    {
        return $this->requiresSteps;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getItemIdentifier(): string
    {
        return $this->id;
    }
}
