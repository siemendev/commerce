<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing;

use Siemendev\Checkout\Item\ItemInterface;
use Siemendev\Checkout\Pricing\Provider\PriceProviderInterface;

class PriceResolver implements PriceResolverInterface
{
    /** @param  array<PriceProviderInterface> $providers */
    public function __construct(private array $providers = [])
    {
    }

    public function addPriceProvider(PriceProviderInterface $provider): static
    {
        $this->providers[] = $provider;

        return $this;
    }

    public function getItemUnitPrice(ItemInterface $item, string $currency): int
    {
        foreach ($this->providers as $priceProvider) {
            if ($priceProvider->eligible($item, $currency)) {
                return $priceProvider->getItemUnitPrice($item, $currency);
            }
        }

        throw new PriceProviderNotFoundException($item, $currency, $this->providers);
    }

    public function getItemTotalPrice(ItemInterface $item, string $currency): int
    {
        foreach ($this->providers as $priceProvider) {
            if ($priceProvider->eligible($item, $currency)) {
                return $priceProvider->getItemTotalPrice($item, $currency);
            }
        }

        throw new PriceProviderNotFoundException($item, $currency, $this->providers);
    }
}
