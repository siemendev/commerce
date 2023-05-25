<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Pricing\Provider;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Pricing\PriceInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

interface PriceProviderInterface
{
    public function eligible(ProductInterface $product): bool;

    public function getPrice(ProductInterface $product, CheckoutDataInterface $data): PriceInterface;
}
