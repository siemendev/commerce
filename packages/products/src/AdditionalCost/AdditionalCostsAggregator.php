<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\AdditionalCost;

use Siemendev\Checkout\Data\CheckoutDataInterface;

class AdditionalCostsAggregator implements AdditionalCostsAggregatorInterface
{
    /**
     * @param array<AdditionalCostProviderInterface> $providers
     */
    public function __construct(
        private array $providers = []
    ) {
    }

    /**
     * @param array<AdditionalCostProviderInterface> $providers
     */
    public function setProviders(array $providers): static
    {
        $this->providers = $providers;

        return $this;
    }

    public function addProvider(AdditionalCostProviderInterface $provider): static
    {
        $this->providers[] = $provider;

        return $this;
    }

    public function getAdditionalCost(CheckoutDataInterface $data): array
    {
        $additionalCosts = [];

        foreach ($this->providers as $provider) {
            if ($provider->eligible($data)) {
                foreach ($provider->getAdditionalCosts($data) as $additionalCost) {
                    $additionalCosts[] = $additionalCost;
                }
            }
        }

        return $additionalCosts;
    }
}
