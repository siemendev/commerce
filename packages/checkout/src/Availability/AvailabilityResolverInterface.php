<?php declare(strict_types=1);

namespace Siemendev\Checkout\Availability;

use Siemendev\Checkout\Availability\Provider\AvailabilityProviderInterface;
use Siemendev\Checkout\Item\ItemInterface;

interface AvailabilityResolverInterface
{
    public function addAvailabilityProvider(AvailabilityProviderInterface $provider): static;

    /**
     * @throws AvailabilityProviderNotFoundException
     */
    public function isAvailable(ItemInterface $item): bool;

    // todo implement cached method isAvailableCached for not-realtime use cases (outside the checkout process)
}
