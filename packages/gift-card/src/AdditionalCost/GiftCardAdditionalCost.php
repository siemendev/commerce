<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\AdditionalCost;


use Siemendev\Checkout\Products\AdditionalCost\AdditionalCostInterface;

class GiftCardAdditionalCost implements AdditionalCostInterface
{
    private int $value;

    public function getLabel(): string
    {
        return 'Gift Card';
    }

    public function setGiftCardValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getAmountNet(): int
    {
        return $this->value * -1;
    }

    public function getAmountGross(): int
    {
        return $this->value * -1;
    }
}
