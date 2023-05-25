<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Availability;

use Siemendev\Checkout\Products\Availability\Exception\AvailabilityProviderNotFoundException;
use Siemendev\Checkout\Products\Availability\Provider\AvailabilityProviderInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;
use Traversable;

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

    public function isAvailable(ProductInterface $product): bool
    {
        foreach ($this->providers as $provider) {
            if ($provider->eligible($product)) {
                return $provider->isAvailable($product);
            }
        }

        throw new AvailabilityProviderNotFoundException($product, $this->providers);
    }
}
