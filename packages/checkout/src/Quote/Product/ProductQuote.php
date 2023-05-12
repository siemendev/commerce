<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Product;

use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Pricing\Product\ProductPriceInterface;

class ProductQuote implements ProductQuoteInterface
{
    private ProductInterface $product;

    private ProductPriceInterface $price;

    public function setProduct(ProductInterface $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getPrice(): ProductPriceInterface
    {
        return $this->price;
    }

    public function setPrice(ProductPriceInterface $price): ProductQuote
    {
        $this->price = $price;

        return $this;
    }
}
