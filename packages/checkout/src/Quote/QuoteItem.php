<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote;

use App\Commerce\Item;

class QuoteItem implements QuoteItemInterface
{
    private Item $item;

    private int $unitPrice;

    private int $totalPrice;

    public function setItem(Item $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function getData(): Item
    {
        return $this->item;
    }

    public function setUnitPrice(int $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    public function setTotalPrice(int $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }
}
