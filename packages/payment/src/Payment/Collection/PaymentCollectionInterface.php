<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Payment\Collection;

use Siemendev\Checkout\Payment\Payment\PaymentInterface;

interface PaymentCollectionInterface
{
    /**
     * Convenience method to get the total amount of all payments in a given currency.
     */
    public function getTotal(string $currency): int;

    public function isEmpty(): bool;

    public function add(PaymentInterface $payment): static;

    /**
     * @return array<string, PaymentInterface> Indexed by payment identifier
     */
    public function getByPaymentMethodIdentifier(string $paymentMethodIdentifier): array;
}
