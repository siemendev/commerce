<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\Data;

use Siemendev\Checkout\Products\Product\ProductInterface;

trait ContainsProductsImmutable
{
    /** @var array<ProductInterface> */
    private array $products = [];

    /**
     * @see ProductCheckoutDataInterface::getProducts()
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}
