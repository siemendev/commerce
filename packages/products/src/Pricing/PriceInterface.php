<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Pricing;

interface PriceInterface
{
    public function getCurrency(): string;

    public function getVatRate(): float;

    public function getUnitPriceNet(): int;

    public function getUnitPriceGross(): int;

    public function getTotalPriceNet(): int;

    public function getTotalPriceGross(): int;
}
