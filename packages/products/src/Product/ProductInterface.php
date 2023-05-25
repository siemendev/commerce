<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Product;

interface ProductInterface
{
    /**
     * Returns a list of step identifiers that are required to be completed before this product can be purchased
     *
     * @return array<string>
     */
    public function requiredSteps(): array;

    /**
     * returns a unique identifier for this product
     */
    public function getIdentifier(): string;

    /**
     * returns the quantity of this product
     */
    public function getQuantity(): int;
}
