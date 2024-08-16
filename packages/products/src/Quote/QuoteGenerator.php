<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\Quote;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\AdditionalCost\AdditionalCostsAggregatorInterface;
use Siemendev\Checkout\Products\Availability\AvailabilityResolverInterface;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;
use Siemendev\Checkout\Products\Pricing\Resolver\PriceResolverInterface;

class QuoteGenerator implements QuoteGeneratorInterface
{
    public function __construct(
        private readonly PriceResolverInterface $priceResolver,
        private readonly AvailabilityResolverInterface $availabilityResolver,
        private readonly AdditionalCostsAggregatorInterface $additionalCostsAggregator,
    ) {}

    public function generate(CheckoutDataInterface $data): Quote
    {
        $quote = (new Quote())->setCurrency($data->getCurrency());

        if (!$data instanceof ProductCheckoutDataInterface) {
            throw new LogicException(sprintf('"%s" needs to implement "%s" to be able to generate a quote (for products)', $data::class, ProductCheckoutDataInterface::class));
        }

        foreach ($data->getProducts() as $product) {
            if (!$this->availabilityResolver->isAvailable($product)) {
                // todo add possibility to report back that the product has been ignored
                continue;
            }

            $quote->addQuoteItem(
                (new QuoteItem())->setProduct($product)->setPrice($this->priceResolver->getPrice($product, $data)),
            );
        }

        foreach ($this->additionalCostsAggregator->getAdditionalCost($data, $quote) as $additionalCost) {
            $quote->addAdditionalCost($additionalCost);
        }

        return $quote;
    }
}
