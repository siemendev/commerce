<?php declare(strict_types=1);

namespace Siemendev\Checkout\Data;

abstract class AbstractCheckoutData implements CheckoutDataInterface
{
    private string $currency;

    private bool $locked = false;

    private bool $finalized = false;

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $string): static
    {
        $this->currency = $string;

        return $this;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function lock(): static
    {
        $this->locked = true;

        return $this;
    }

    public function isFinalized(): bool
    {
        return $this->finalized;
    }

    public function finalize(): static
    {
        $this->finalized = true;
        $this->lock();

        return $this;
    }
}
