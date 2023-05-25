<?php declare(strict_types=1);

namespace Siemendev\Checkout\Taxation;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

interface EuropeanVatTaxResolverInterface
{
    public function getProductTaxRate(ProductInterface $product, CheckoutDataInterface $data): float;
}
