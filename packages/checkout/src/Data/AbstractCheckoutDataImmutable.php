<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Data;

use LogicException;

abstract class AbstractCheckoutDataImmutable implements CheckoutDataInterface
{
    protected string $currency;

    protected bool $locked = false;

    protected bool $finalized = false;

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function lock(): static
    {
        throw new LogicException('Cannot lock immutable checkout data!');
    }

    public function isFinalized(): bool
    {
        return $this->finalized;
    }

    public function finalize(): static
    {
        throw new LogicException('Cannot finalize immutable checkout data!');
    }
}
