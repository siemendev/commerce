<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing\Product;

use Siemendev\Checkout\Pricing\PriceInterface;

interface ProductPriceInterface extends PriceInterface
{
    public function getCurrency(): string;

    public function getUnitPrice(): int;

    public function getTotalPrice(): int;
}
