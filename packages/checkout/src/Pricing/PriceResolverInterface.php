<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing;

use Siemendev\Checkout\Item\ItemInterface;
use Siemendev\Checkout\Pricing\Provider\PriceProviderInterface;

interface PriceResolverInterface
{
    public function addPriceProvider(PriceProviderInterface $provider): static;

    /**
     * @throws PriceProviderNotFoundException
     */
    public function getItemUnitPrice(ItemInterface $item, string $currency): int;

    /**
     * @throws PriceProviderNotFoundException
     */
    public function getItemTotalPrice(ItemInterface $item, string $currency): int;

    // todo implement cached method getPriceCached for not-realtime use cases (outside the checkout process)
}
