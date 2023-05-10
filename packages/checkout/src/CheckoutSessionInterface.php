<?php declare(strict_types=1);

namespace Siemendev\Checkout;

use Siemendev\Checkout\Item\ItemInterface;

interface CheckoutSessionInterface
{
    /**
     * Get the currency of the current checkout session. Has to be a valid 3-digit ISO 4217 currency code.
     */
    public function getCurrency(): string;

    /**
     * Get the items of the current checkout session.
     *
     * @return array<ItemInterface>
     */
    public function getItems(): array;
}
