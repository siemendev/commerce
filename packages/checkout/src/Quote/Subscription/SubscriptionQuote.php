<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Subscription;

use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;
use Siemendev\Checkout\Pricing\Subscription\SubscriptionPriceInterface;

class SubscriptionQuote implements SubscriptionQuoteInterface
{
    private SubscriptionInterface $subscription;

    private SubscriptionPriceInterface $price;

    public function setSubscription(SubscriptionInterface $subscription): static
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getSubscription(): SubscriptionInterface
    {
        return $this->subscription;
    }

    public function setPrice(SubscriptionPriceInterface $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): SubscriptionPriceInterface
    {
        return $this->price;
    }
}
