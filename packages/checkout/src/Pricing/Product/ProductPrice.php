<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing\Product;

class ProductPrice implements ProductPriceInterface
{
    private string $currency;

    private int $unitPrice;

    private int $totalPrice;

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $string): static
    {
        $this->currency = $string;

        return $this;
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(int $int): static
    {
        $this->unitPrice = $int;

        return $this;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $int): static
    {
        $this->totalPrice = $int;

        return $this;
    }
}
