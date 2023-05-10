<?php declare(strict_types=1);

namespace Siemendev\Checkout\Availability\Provider;

use Siemendev\Checkout\Item\ItemInterface;

interface AvailabilityProviderInterface
{
    public function eligible(ItemInterface $item): bool;

    public function isAvailable(ItemInterface $item): bool;
}
