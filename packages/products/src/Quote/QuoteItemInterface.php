<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\Quote;

use Siemendev\Checkout\Products\Pricing\PriceInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

interface QuoteItemInterface
{
    public function getProduct(): ProductInterface;

    public function getPrice(): PriceInterface;

    public function getQuantity(): int;
}
