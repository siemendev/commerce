<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Builder\Part;

use Siemendev\Checkout\Availability\AvailabilityResolverInterface;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Pricing\PriceResolverInterface;
use Siemendev\Checkout\Quote\Action\RemoveProductQuoteAction;
use Siemendev\Checkout\Quote\Action\RemoveSubscriptionQuoteAction;
use Siemendev\Checkout\Quote\Product\ProductQuote;
use Siemendev\Checkout\Quote\QuoteInterface;
use Siemendev\Checkout\Quote\Subscription\SubscriptionQuote;

class SubscriptionsQuotePartBuilder implements QuotePartBuilderInterface
{
    public function __construct(
        private readonly PriceResolverInterface $priceResolver,
        private readonly AvailabilityResolverInterface $availabilityResolver,
    ) {
    }

    public function build(QuoteInterface $quote, CheckoutDataInterface $data): void
    {
        foreach ($data->getCart()->getSubscriptions() as $subscription) {
            if (!$this->availabilityResolver->isAvailable($subscription)) {
                $quote->addAction(
                    new RemoveSubscriptionQuoteAction($subscription, RemoveSubscriptionQuoteAction::REASON_UNAVAILABLE)
                );
                continue;
            }
            $quote->addSubscription(
                (new SubscriptionQuote())
                    ->setSubscription($subscription)
                    ->setPrice($this->priceResolver->getSubscriptionPrice($subscription))
            );
        }
    }
}
