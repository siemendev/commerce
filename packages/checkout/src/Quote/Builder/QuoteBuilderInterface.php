<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Builder;

use Siemendev\Checkout\Availability\AvailabilityProviderNotFoundException;
use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Pricing\PriceProviderNotFoundException;
use Siemendev\Checkout\Quote\Quote;

interface QuoteBuilderInterface
{
    /**
     * @throws PriceProviderNotFoundException
     * @throws AvailabilityProviderNotFoundException
     */
    public function getQuote(CheckoutSessionInterface $session): Quote;
}
