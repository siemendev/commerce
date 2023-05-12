<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Product;

use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Pricing\Product\ProductPriceInterface;

interface ProductQuoteInterface
{
    public function getProduct(): ProductInterface;

    public function getPrice(): ProductPriceInterface;
}
