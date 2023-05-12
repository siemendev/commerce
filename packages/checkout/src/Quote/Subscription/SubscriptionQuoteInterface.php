<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Subscription;

use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;
use Siemendev\Checkout\Pricing\Subscription\SubscriptionPriceInterface;

interface SubscriptionQuoteInterface
{
    public function getSubscription(): SubscriptionInterface;

    public function getPrice(): SubscriptionPriceInterface;
}
