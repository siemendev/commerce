<?php declare(strict_types=1);

namespace Siemendev\Checkout\Availability;

use Siemendev\Checkout\Availability\Provider\AvailabilityProviderInterface;
use Siemendev\Checkout\Item\ItemInterface;

class AvailabilityResolver implements AvailabilityResolverInterface
{
    /** @param array<AvailabilityProviderInterface> $providers */
    public function __construct(private array $providers = [])
    {
    }

    /** @param array<AvailabilityProviderInterface> $providers */
    public function setAvailabilityProviders(array $providers): static
    {
        $this->providers = $providers;

        return $this;
    }

    public function addAvailabilityProvider(AvailabilityProviderInterface $provider): static
    {
        $this->providers[] = $provider;

        return $this;
    }

    public function isAvailable(ItemInterface $item): bool
    {
        foreach ($this->providers as $provider) {
            if ($provider->eligible($item)) {
                return $provider->isAvailable($item);
            }
        }

        throw new AvailabilityProviderNotFoundException($item, $this->providers);
    }
}
