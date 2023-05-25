<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Quote;

use Siemendev\Checkout\Products\Pricing\PriceInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

class QuoteItem implements QuoteItemInterface
{
    private ProductInterface $product;

    private PriceInterface $price;

    public function setProduct(ProductInterface $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getPrice(): PriceInterface
    {
        return $this->price;
    }

    public function setPrice(PriceInterface $price): QuoteItem
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->product->getQuantity();
    }
}
