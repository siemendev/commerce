<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Availability;

use Siemendev\Checkout\Products\Availability\Exception\AvailabilityProviderNotFoundException;
use Siemendev\Checkout\Products\Availability\Provider\AvailabilityProviderInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

interface AvailabilityResolverInterface
{
    public function addAvailabilityProvider(AvailabilityProviderInterface $provider): static;

    /**
     * @throws AvailabilityProviderNotFoundException
     */
    public function isAvailable(ProductInterface $product): bool;
}
