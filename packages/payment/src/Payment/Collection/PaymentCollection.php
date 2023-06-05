<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Payment\Collection;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use JsonSerializable;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Traversable;

class PaymentCollection implements PaymentCollectionInterface, Countable, IteratorAggregate, ArrayAccess, JsonSerializable
{
    /**
     * @param array<PaymentInterface> $payments
     */
    private array $payments = [];

    /**
     * @param array<PaymentInterface> $payments
     */
    public function __construct(
        array $payments = [],
    ) {
        foreach ($payments as $payment) {
            $this->add($payment);
        }
    }

    public function getTotal(?string $currency = null): int
    {
        return array_sum(
            array_map(
                static fn(PaymentInterface $payment) => $payment->getAmount(),
                null === $currency ? $this->payments : array_filter(
                    $this->payments,
                    static fn (PaymentInterface $payment) => $payment->getCurrency() === $currency,
                ),
            ),
        );
    }

    public function isEmpty(): bool
    {
        return 0 === count($this->payments);
    }

    public function add(PaymentInterface $payment): static
    {
        $this->payments[$payment->getIdentifier()] = $payment;

        return $this;
    }


    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->payments);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->payments[$offset]);
    }

    public function offsetGet(mixed $offset): ?PaymentInterface
    {
        return $this->payments[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof PaymentInterface) {
            throw new InvalidArgumentException('Only instances of ' . PaymentInterface::class . ' can be added to the collection');
        }

        $this->payments[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->payments[$offset]);
    }

    public function count(): int
    {
        return count($this->payments);
    }

    public function jsonSerialize(): array
    {
        return $this->payments;
    }
}