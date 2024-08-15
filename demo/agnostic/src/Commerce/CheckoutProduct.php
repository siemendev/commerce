<?php

declare(strict_types=1);

namespace Demo\Commerce;

use Siemendev\Checkout\Products\Product\ProductInterface;
use Siemendev\Checkout\Taxation\VatTyped;
use Siemendev\Checkout\Taxation\VatTypedItemInterface;

class CheckoutProduct implements ProductInterface, VatTypedItemInterface
{
    use VatTyped;

    private string $id;

    private string $name;

    private int $quantity = 1;

    private array $requiredSteps = [];

    public function getIdentifier(): string
    {
        return $this->id;
    }

    public function setIdentifier(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function requiredSteps(): array
    {
        return $this->requiredSteps;
    }

    public function addRequiredStep(string $stepIdentifier): static
    {
        $this->requiredSteps[] = $stepIdentifier;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
