<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing\Subscription\Provider;

use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;
use Siemendev\Checkout\Pricing\Subscription\SubscriptionPriceInterface;

interface SubscriptionPriceProviderInterface
{
    public function eligible(SubscriptionInterface $subscription): bool;

    public function getSubscriptionPrice(SubscriptionInterface $subscription): SubscriptionPriceInterface;
}
