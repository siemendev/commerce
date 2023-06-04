<?php declare(strict_types=1);

namespace Siemendev\Checkout\Data;

abstract class AbstractCheckoutData implements CheckoutDataInterface
{
    private string $currency;

    private bool $locked = false;

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

    public function lock(): void
    {
        $this->locked = true;
    }
}
