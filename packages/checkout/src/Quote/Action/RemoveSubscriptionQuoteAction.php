<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Action;

use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;

class RemoveSubscriptionQuoteAction implements QuoteActionInterface
{
    public const REASON_UNAVAILABLE = 'unavailable';

    public function __construct(
        public readonly SubscriptionInterface $subscription,
        public readonly string $reason,
    ) {
    }
}
