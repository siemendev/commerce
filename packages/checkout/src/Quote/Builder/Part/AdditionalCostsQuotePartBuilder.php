<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Builder\Part;

use Siemendev\Checkout\Availability\AvailabilityResolverInterface;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Pricing\PriceResolverInterface;
use Siemendev\Checkout\Quote\Action\RemoveProductQuoteAction;
use Siemendev\Checkout\Quote\Action\RemoveSubscriptionQuoteAction;
use Siemendev\Checkout\Quote\AdditionalCost\AdditionalCostProviderInterface;
use Siemendev\Checkout\Quote\Product\ProductQuote;
use Siemendev\Checkout\Quote\QuoteInterface;
use Siemendev\Checkout\Quote\Subscription\SubscriptionQuote;

class AdditionalCostsQuotePartBuilder implements QuotePartBuilderInterface
{
    /**
     * @param array<AdditionalCostProviderInterface> $additionalCostProviders
     */
    public function __construct(
        private array $additionalCostProviders = [],
    ) {
    }

    public function addAdditionalCostProvider(AdditionalCostProviderInterface $additionalCostProvider): static
    {
        $this->additionalCostProviders[] = $additionalCostProvider;

        return $this;
    }

    public function build(QuoteInterface $quote, CheckoutDataInterface $data): void
    {
        foreach ($this->additionalCostProviders as $additionalCostProvider) {
            if (!$additionalCostProvider->eligible($data)) {
                continue;
            }
            foreach ($additionalCostProvider->getAdditionalCosts($data) as $additionalCost) {
                $quote
                    ->addAdditionalCost($additionalCost)
                    ->setTotalNet($quote->getTotalNet() + $additionalCost->getAmountNet())
                    ->setTotalGross($quote->getTotalGross() + $additionalCost->getAmountNet())
                ;
            }
        }
    }
}
