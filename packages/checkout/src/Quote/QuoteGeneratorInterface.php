<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote;

use Siemendev\Checkout\Availability\AvailabilityProviderNotFoundException;
use Siemendev\Checkout\Availability\AvailabilityResolver;
use Siemendev\Checkout\Availability\AvailabilityResolverInterface;
use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Pricing\PriceProviderNotFoundException;
use Siemendev\Checkout\Pricing\PriceResolver;
use Siemendev\Checkout\Pricing\PriceResolverInterface;

interface QuoteGeneratorInterface
{
    /**
     * @throws PriceProviderNotFoundException
     * @throws AvailabilityProviderNotFoundException
     */
    public function getQuote(CheckoutSessionInterface $session): Quote;
}
