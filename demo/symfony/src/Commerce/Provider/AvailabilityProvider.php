<?php declare(strict_types=1);

namespace App\Commerce\Provider;

use Siemendev\Checkout\Availability\Provider\AvailabilityProviderInterface;
use Siemendev\Checkout\Item\ItemInterface;
use Siemendev\Checkout\Item\QuantifiableItemInterface;

class AvailabilityProvider implements AvailabilityProviderInterface
{
    public function eligible(ItemInterface $item): bool
    {
        return true;
    }

    public function isAvailable(ItemInterface $item): bool
    {
        $quantity = $item instanceof QuantifiableItemInterface ? $item->getQuantity() : 1;

        return true; // todo implement
    }
}
