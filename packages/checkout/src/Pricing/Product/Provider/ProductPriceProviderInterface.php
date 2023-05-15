<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing\Product\Provider;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Pricing\Product\ProductPriceInterface;

interface ProductPriceProviderInterface
{
    public function eligible(ProductInterface $product): bool;

    public function getProductPrice(ProductInterface $product, CheckoutDataInterface $data): ProductPriceInterface;
}
