<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\Pricing;

class Price implements PriceInterface
{
    public function __construct(
        private readonly float $vatRate,
        private readonly int $unitPriceNet,
        private readonly int $unitPriceGross,
        private readonly int $totalPriceNet,
        private readonly int $totalPriceGross,
    ) {}

    public function createFromGrossPrice(int $grossPrice, float $vatRate, int $quantity = 1): self
    {
        $netPrice = (int) round($grossPrice / (100 + $vatRate) * 100);

        return new self(
            vatRate: $vatRate,
            unitPriceNet: $netPrice,
            unitPriceGross: $grossPrice,
            totalPriceNet: $netPrice * $quantity,
            totalPriceGross: $grossPrice * $quantity,
        );
    }

    public static function createFromNetPrice(int $netPrice, float $vatRate, int $quantity = 1): self
    {
        $grossPrice = (int) round($netPrice + $netPrice / 100 * $vatRate);

        return new self(
            vatRate: $vatRate,
            unitPriceNet: $netPrice,
            unitPriceGross: $grossPrice,
            totalPriceNet: $netPrice * $quantity,
            totalPriceGross: $grossPrice * $quantity,
        );
    }

    public function getVatRate(): float
    {
        return $this->vatRate;
    }

    public function getUnitPriceNet(): int
    {
        return $this->unitPriceNet;
    }

    public function getTotalPriceNet(): int
    {
        return $this->totalPriceNet;
    }

    public function getUnitPriceGross(): int
    {
        return $this->unitPriceGross;
    }

    public function getTotalPriceGross(): int
    {
        return $this->totalPriceGross;
    }
}
