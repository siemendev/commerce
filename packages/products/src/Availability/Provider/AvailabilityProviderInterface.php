<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Availability\Provider;

use Siemendev\Checkout\Products\Product\ProductInterface;

interface AvailabilityProviderInterface
{
    public function eligible(ProductInterface $product): bool;

    public function isAvailable(ProductInterface $product): bool;
}
