<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Payment\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Traversable;


interface PaymentCollectionInterface extends Countable, IteratorAggregate, ArrayAccess
{
    /**
     * Convenience method to get the total amount of all payments in a given currency.
     */
    public function getTotal(string $currency): int;

    public function isEmpty(): bool;

    public function add(PaymentInterface $payment): static;

    /**
     * @param array<PaymentInterface> $payments
     */
    public function set(array $payments): static;

    public function remove(PaymentInterface $payment): static;

    /**
     * @return array<string, PaymentInterface> Indexed by payment identifier
     */
    public function getByPaymentMethodIdentifier(string $paymentMethodIdentifier): array;

    /**
     * @return Traversable<PaymentInterface>
     */
    public function getIterator(): Traversable;
}
