<?php declare(strict_types=1);

namespace App\Commerce\Provider;

use Siemendev\Checkout\Item\ItemInterface;
use Siemendev\Checkout\Item\QuantifiableItemInterface;
use Siemendev\Checkout\Pricing\Provider\PriceProviderInterface;

class PriceProvider implements PriceProviderInterface
{
    public function eligible(ItemInterface $item, string $currency): bool
    {
        return true;
    }

    public function getItemTotalPrice(ItemInterface $item, string $currency): int
    {
        $quantity = $item instanceof QuantifiableItemInterface ? $item->getQuantity() : 1;

        return $this->getItemUnitPrice($item, $currency) * $quantity;
    }

    public function getItemUnitPrice(ItemInterface $item, string $currency): int
    {
        return 1000;
    }
}
