<?php declare(strict_types=1);

namespace Siemendev\Checkout\Item;

interface QuantifiableItemInterface
{
    public function getQuantity(): int;
}
