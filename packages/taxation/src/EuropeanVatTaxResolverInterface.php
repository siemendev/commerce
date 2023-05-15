<?php declare(strict_types=1);

namespace Siemendev\Checkout\Taxation;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Item\ItemInterface;

interface EuropeanVatTaxResolverInterface
{
    public function getItemTaxRate(ItemInterface $item, CheckoutDataInterface $data): float;
}
