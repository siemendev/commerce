<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Payment\Collection;

interface PaymentCollectionInterface
{
    /**
     * Convenience method to get the total amount of all payments in a given currency.
     */
    public function getTotal(string $currency): int;

    public function isEmpty(): bool;
}
