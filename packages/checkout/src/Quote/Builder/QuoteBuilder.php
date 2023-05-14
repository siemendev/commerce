<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Builder;

use Siemendev\Checkout\Availability\AvailabilityResolverInterface;
use Siemendev\Checkout\Cart\CartInterface;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Pricing\PriceResolverInterface;
use Siemendev\Checkout\Quote\Action\RemoveProductQuoteAction;
use Siemendev\Checkout\Quote\Action\RemoveSubscriptionQuoteAction;
use Siemendev\Checkout\Quote\AdditionalCost\AdditionalCostProviderInterface;
use Siemendev\Checkout\Quote\Product\ProductQuote;
use Siemendev\Checkout\Quote\Quote;
use Siemendev\Checkout\Quote\Subscription\SubscriptionQuote;

class QuoteBuilder implements QuoteBuilderInterface
{
    /**
     * @param array<AdditionalCostProviderInterface> $additionalCostProviders
     */
    public function __construct(
        private readonly PriceResolverInterface $priceResolver,
        private readonly AvailabilityResolverInterface $availabilityResolver,
        private readonly array $additionalCostProviders = [],
    ) {
    }

    public function getQuoteByCheckoutData(CheckoutDataInterface $data): Quote
    {
        $quote = $this->getQuoteByCart($data->getCart());

        foreach ($this->additionalCostProviders as $additionalCostProvider) {
            if (!$additionalCostProvider->eligible($data)) {
                continue;
            }
            foreach ($additionalCostProvider->getAdditionalCosts($data) as $additionalCost) {
                $quote->addAdditionalCost($additionalCost);
            }
        }

        return $quote;
    }

    public function getQuoteByCart(CartInterface $cart): Quote
    {
        $quote = new Quote();

        foreach ($cart->getProducts() as $product) {
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

        foreach ($cart->getSubscriptions() as $subscription) {
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
