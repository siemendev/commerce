<?php declare(strict_types=1);

namespace App\Commerce\Provider;

use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;
use Siemendev\Checkout\Pricing\Product\ProductPrice;
use Siemendev\Checkout\Pricing\Product\ProductPriceInterface;
use Siemendev\Checkout\Pricing\Product\Provider\ProductPriceProviderInterface;
use Siemendev\Checkout\Pricing\Subscription\SubscriptionPrice;
use Siemendev\Checkout\Pricing\Subscription\SubscriptionPriceInterface;
use Siemendev\Checkout\Pricing\Subscription\Provider\SubscriptionPriceProviderInterface;

class PriceProvider implements ProductPriceProviderInterface, SubscriptionPriceProviderInterface
{
    public function eligible(ProductInterface|SubscriptionInterface $item): bool
    {
        return true;
    }

    public function getProductPrice(ProductInterface $product): ProductPriceInterface
    {
        return (new ProductPrice())
            ->setCurrency('EUR')
            ->setUnitPrice(1000)
            ->setTotalPrice(2000)
        ;
    }

    public function getSubscriptionPrice(SubscriptionInterface $subscription): SubscriptionPriceInterface
    {
        return (new SubscriptionPrice());
    }
}
