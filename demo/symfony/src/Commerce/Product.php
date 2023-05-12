<?php declare(strict_types=1);

namespace App\Commerce;

use Siemendev\Checkout\Item\Quantifiable;
use Siemendev\Checkout\Item\RequiredSteps;
use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Item\QuantifiableItemInterface;

class Product implements ProductInterface, QuantifiableItemInterface
{
    use RequiredSteps, Quantifiable;

    private string $id;

    private string $name;

    public function getItemIdentifier(): string
    {
        return $this->id;
    }

    public function setId(string $id): static
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
}
