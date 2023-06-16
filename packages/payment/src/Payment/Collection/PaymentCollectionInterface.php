<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Payment\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Traversable;

/**
 * @extends ArrayAccess<string, PaymentInterface>
 * @extends IteratorAggregate<string, PaymentInterface>
 */
interface PaymentCollectionInterface extends Countable, IteratorAggregate, ArrayAccess
{
    /**
     * Convenience method to get the total amount of all payments in a given currency.
     */
    public function getAuthorizedTotal(string $currency): int;

    public function isEmpty(): bool;

    public function add(PaymentInterface $payment): static;

    /**
     * @param array<PaymentInterface> $payments
     */
    public function set(array $payments): static;

    public function remove(PaymentInterface $payment): static;

    /**
     * @return array<PaymentInterface>
     */
    public function getAuthorizedPayments(): array;

    /**
     * Returns the payments in the order of their priority.
     *
     * @return array<PaymentInterface>
     */
    public function getPrioritized(): array;

    /**
     * Returns the payments that have already been captured.
     *
     * @return array<PaymentInterface>
     */
    public function getCaptured(): array;

    /**
     * @return Traversable<PaymentInterface>
     */
    public function getIterator(): Traversable;
}
