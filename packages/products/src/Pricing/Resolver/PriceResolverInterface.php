<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\Pricing\Resolver;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Pricing\PriceInterface;
use Siemendev\Checkout\Products\Pricing\PriceProviderNotFoundException;
use Siemendev\Checkout\Products\Product\ProductInterface;

interface PriceResolverInterface
{
    /**
     * @throws PriceProviderNotFoundException
     */
    public function getPrice(ProductInterface $product, CheckoutDataInterface $data): PriceInterface;
}
