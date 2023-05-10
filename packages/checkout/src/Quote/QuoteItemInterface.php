<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote;

use Siemendev\Checkout\Item\ItemInterface;

interface QuoteItemInterface
{
    public function getData(): ItemInterface;

    public function getUnitPrice(): int;

    public function getTotalPrice(): int;
}
