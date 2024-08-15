<?php

declare(strict_types=1);

namespace Demo\Commerce\Provider;

use Siemendev\Checkout\Products\Availability\Provider\AvailabilityProviderInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

class AvailabilityProvider implements AvailabilityProviderInterface
{
    public function eligible(ProductInterface $product): bool
    {
        return true;
    }

    public function isAvailable(ProductInterface $product): bool
    {
        return true; // todo implement
    }
}
