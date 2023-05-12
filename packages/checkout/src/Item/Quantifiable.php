<?php declare(strict_types=1);

namespace Siemendev\Checkout\Item;

trait Quantifiable
{
    private int $quantity = 1;

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
