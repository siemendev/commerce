<?php declare(strict_types=1);

namespace App\Commerce\Provider;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;
use Siemendev\Checkout\Pricing\Product\ProductPrice;
use Siemendev\Checkout\Pricing\Product\ProductPriceInterface;
use Siemendev\Checkout\Pricing\Product\Provider\ProductPriceProviderInterface;
use Siemendev\Checkout\Pricing\Subscription\SubscriptionPrice;
use Siemendev\Checkout\Pricing\Subscription\SubscriptionPriceInterface;
use Siemendev\Checkout\Pricing\Subscription\Provider\SubscriptionPriceProviderInterface;
use Siemendev\Checkout\Taxation\EuropeanVatTaxResolverInterface;

class PriceProvider implements ProductPriceProviderInterface, SubscriptionPriceProviderInterface
{
    public function __construct(
        private readonly EuropeanVatTaxResolverInterface $taxResolver,
    ) {
    }

    public function eligible(ProductInterface|SubscriptionInterface $item): bool
    {
        return true;
    }

    public function getProductPrice(ProductInterface $product, CheckoutDataInterface $data): ProductPriceInterface
    {
        return ProductPrice::createFromNetPrice(
            1000,
            $this->taxResolver->getItemTaxRate($product, $data),
            'EUR',
            $product->getQuantity(),
        );
    }

    public function getSubscriptionPrice(SubscriptionInterface $subscription): SubscriptionPriceInterface
    {
        return (new SubscriptionPrice());
    }
}
