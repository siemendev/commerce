<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing\Provider;

use Siemendev\Checkout\Item\ItemInterface;

interface PriceProviderInterface
{
    public function eligible(ItemInterface $item, string $currency): bool;

    public function getItemTotalPrice(ItemInterface $item, string $currency): int;

    public function getItemUnitPrice(ItemInterface $item, string $currency): int;
}
