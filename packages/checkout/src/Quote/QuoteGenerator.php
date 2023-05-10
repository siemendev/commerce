<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote;

use Siemendev\Checkout\Availability\AvailabilityProviderNotFoundException;
use Siemendev\Checkout\Availability\AvailabilityResolver;
use Siemendev\Checkout\Availability\AvailabilityResolverInterface;
use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Pricing\PriceProviderNotFoundException;
use Siemendev\Checkout\Pricing\PriceResolver;
use Siemendev\Checkout\Pricing\PriceResolverInterface;

class QuoteGenerator implements QuoteGeneratorInterface
{
    private readonly PriceResolverInterface $priceResolver;

    private readonly AvailabilityResolverInterface $availabilityResolver;

    public function __construct(
        ?PriceResolverInterface $priceResolver = null,
        ?AvailabilityResolverInterface $availabilityResolver = null,
    ) {
        $this->priceResolver = $priceResolver ?? new PriceResolver();
        $this->availabilityResolver = $availabilityResolver ?? new AvailabilityResolver();
    }

    /**
     * @throws PriceProviderNotFoundException
     * @throws AvailabilityProviderNotFoundException
     */
    public function getQuote(CheckoutSessionInterface $session): Quote
    {
        $quote = (new Quote())
            ->setCurrency($session->getCurrency())
        ;

        foreach ($session->getItems() as $sessionItem) {
            if (!$this->availabilityResolver->isAvailable($sessionItem)) {
                // todo add notice, remove product from session or whatever
                continue;
            }
            $quote->addItem((new QuoteItem())
                ->setData($sessionItem)
                ->setTotalPrice($this->priceResolver->getItemTotalPrice($sessionItem, $session->getCurrency()))
                ->setUnitPrice($this->priceResolver->getItemUnitPrice($sessionItem, $session->getCurrency()))
            );
        }

        return $quote;
    }
}
