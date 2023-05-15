<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;
use Siemendev\Checkout\Pricing\Product\ProductPriceInterface;
use Siemendev\Checkout\Pricing\Subscription\SubscriptionPriceInterface;

// todo split into separate interfaces
interface PriceResolverInterface
{
    public function getProductPrice(ProductInterface $product, CheckoutDataInterface $data): ProductPriceInterface;

    public function getSubscriptionPrice(SubscriptionInterface $subscription): SubscriptionPriceInterface;
}
