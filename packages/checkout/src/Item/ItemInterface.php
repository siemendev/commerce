<?php declare(strict_types=1);

namespace Siemendev\Checkout\Item;

interface ItemInterface
{
    /**
     * Returns a list of interface names that are required to be implemented in the checkout data
     *
     * @return array<class-string>
     */
    public function requiredCheckoutDataInterfaces(): array;

    /**
     * returns a unique identifier for this item
     */
    public function getItemIdentifier(): string;

    public function getQuantity(): int;
}
