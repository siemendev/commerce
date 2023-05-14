<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Trait;

use Siemendev\Checkout\Quote\Subscription\SubscriptionQuoteInterface;

trait WithSubscriptions
{
    /** @var array<SubscriptionQuoteInterface> */
    private array $subscriptions = [];

    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    public function addSubscription(SubscriptionQuoteInterface $subscription): static
    {
        $this->subscriptions[] = $subscription;

        return $this;
    }
}
