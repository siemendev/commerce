<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Pricing\Resolver;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Pricing\PriceInterface;
use Siemendev\Checkout\Products\Pricing\PriceProviderNotFoundException;
use Siemendev\Checkout\Products\Pricing\Provider\PriceProviderInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;
use Traversable;

class PriceResolver implements PriceResolverInterface
{
    /**
     * @param array<PriceProviderInterface> $providers
     */
    public function __construct(
        private array $providers = [],
    ) {
    }

    public function addProvider(PriceProviderInterface $priceProvider): static
    {
        $this->providers[] = $priceProvider;

        return $this;
    }

    /**
     * @param array<PriceProviderInterface> $providers
     */
    public function setProviders(array $providers): static
    {
        $this->providers = $providers;

        return $this;
    }

    public function getPrice(ProductInterface $product, CheckoutDataInterface $data): PriceInterface
    {
        foreach ($this->providers as $priceProvider) {
            if ($priceProvider->eligible($product)) {
                return $priceProvider->getPrice($product, $data);
            }
        }

        throw new PriceProviderNotFoundException($product, $this->providers);
    }
}
