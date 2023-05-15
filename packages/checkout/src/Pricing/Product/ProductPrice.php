<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing\Product;

class ProductPrice implements ProductPriceInterface
{
    private string $currency;

    private float $vatRate;

    private int $unitPriceNet;

    private int $unitPriceGross;

    private int $totalPriceNet;

    private int $totalPriceGross;

    public function createFromGrossPrice(int $grossPrice, float $vatRate, string $currency, int $quantity): static
    {
        $netPrice = (int) round($grossPrice / (100 + $vatRate) * 100);

        return (new static())
            ->setCurrency($currency)
            ->setVatRate($vatRate)
            ->setUnitPriceNet($netPrice)
            ->setUnitPriceGross($grossPrice)
            ->setTotalPriceNet($netPrice * $quantity)
            ->setTotalPriceGross($grossPrice * $quantity)
        ;
    }

    public static function createFromNetPrice(int $netPrice, float $vatRate, string $currency, int $quantity): static
    {
        $grossPrice = (int) round($netPrice + $netPrice / 100 * $vatRate);

        return (new static())
            ->setCurrency($currency)
            ->setVatRate($vatRate)
            ->setUnitPriceNet($netPrice)
            ->setUnitPriceGross($grossPrice)
            ->setTotalPriceNet($netPrice * $quantity)
            ->setTotalPriceGross($grossPrice * $quantity)
        ;
    }

    public function getVatRate(): float
    {
        return $this->vatRate;
    }

    public function setVatRate(float $vatRate): static
    {
        $this->vatRate = $vatRate;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $string): static
    {
        $this->currency = $string;

        return $this;
    }

    public function getUnitPriceNet(): int
    {
        return $this->unitPriceNet;
    }

    public function setUnitPriceNet(int $int): static
    {
        $this->unitPriceNet = $int;

        return $this;
    }

    public function getTotalPriceNet(): int
    {
        return $this->totalPriceNet;
    }

    public function setTotalPriceNet(int $int): static
    {
        $this->totalPriceNet = $int;

        return $this;
    }

    public function getUnitPriceGross(): int
    {
        return $this->unitPriceGross;
    }

    public function setUnitPriceGross(int $unitPriceGross): static
    {
        $this->unitPriceGross = $unitPriceGross;

        return $this;
    }

    public function getTotalPriceGross(): int
    {
        return $this->totalPriceGross;
    }

    public function setTotalPriceGross(int $totalPriceGross): static
    {
        $this->totalPriceGross = $totalPriceGross;

        return $this;
    }
}
