<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing\Product;

use Siemendev\Checkout\Pricing\PriceInterface;

interface ProductPriceInterface extends PriceInterface
{
    public function getCurrency(): string;

    public function getVatRate(): float;

    public function getUnitPriceNet(): int;

    public function getUnitPriceGross(): int;

    public function getTotalPriceNet(): int;

    public function getTotalPriceGross(): int;
}
