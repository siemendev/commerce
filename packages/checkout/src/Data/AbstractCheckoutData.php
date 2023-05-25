<?php declare(strict_types=1);

namespace Siemendev\Checkout\Data;

abstract class AbstractCheckoutData implements CheckoutDataInterface
{
    private string $currency;

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $string): static
    {
        $this->currency = $string;

        return $this;
    }
}
