<?php declare(strict_types=1);

namespace Siemendev\Checkout\Taxation;

use Siemendev\Checkout\Products\Product\ProductInterface;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutDataInterface;

interface EuropeanVatTaxResolverInterface
{
    public function getProductTaxRate(ProductInterface $product, BillingAddressableCheckoutDataInterface $data): float;
}
