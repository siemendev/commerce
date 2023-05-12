<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Builder;

use Siemendev\Checkout\Availability\AvailabilityProviderNotFoundException;
use Siemendev\Checkout\Availability\AvailabilityResolverInterface;
use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Pricing\PriceProviderNotFoundException;
use Siemendev\Checkout\Pricing\PriceResolverInterface;
use Siemendev\Checkout\Quote\Action\RemoveProductQuoteAction;
use Siemendev\Checkout\Quote\Action\RemoveSubscriptionQuoteAction;
use Siemendev\Checkout\Quote\Product\ProductQuote;
use Siemendev\Checkout\Quote\Quote;
use Siemendev\Checkout\Quote\Subscription\SubscriptionQuote;

class QuoteBuilder implements QuoteBuilderInterface
{
    public function __construct(
        private readonly PriceResolverInterface $priceResolver,
        private readonly AvailabilityResolverInterface $availabilityResolver,
    ) {
    }

    /**
     * @throws PriceProviderNotFoundException
     * @throws AvailabilityProviderNotFoundException
     */
    public function getQuote(CheckoutSessionInterface $session): Quote
    {
        $quote = new Quote();

        foreach ($session->getProducts() as $product) {
            if (!$this->availabilityResolver->isAvailable($product)) {
                $quote->addAction(
                    new RemoveProductQuoteAction($product, RemoveProductQuoteAction::REASON_UNAVAILABLE)
                );
                continue;
            }
            $quote->addProduct(
                (new ProductQuote())
                    ->setProduct($product)
                    ->setPrice($this->priceResolver->getProductPrice($product))
            );
        }

        foreach ($session->getSubscriptions() as $subscription) {
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

        return $quote;
    }
}
