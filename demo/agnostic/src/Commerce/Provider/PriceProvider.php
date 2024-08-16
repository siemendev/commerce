<?php

declare(strict_types=1);

namespace Demo\Commerce\Provider;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Pricing\Price;
use Siemendev\Checkout\Products\Pricing\PriceInterface;
use Siemendev\Checkout\Products\Pricing\Provider\PriceProviderInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;
use Siemendev\Checkout\Taxation\EuropeanVatTaxResolverInterface;

class PriceProvider implements PriceProviderInterface
{
    public function __construct(
        private readonly EuropeanVatTaxResolverInterface $taxResolver,
    ) {}

    public function eligible(ProductInterface $product): bool
    {
        return true;
    }

    public function getPrice(ProductInterface $product, CheckoutDataInterface $data): PriceInterface
    {
        return Price::createFromNetPrice(
            1000,
            $this->taxResolver->getProductTaxRate($product, $data),
            $product->getQuantity(),
        );
    }
}
