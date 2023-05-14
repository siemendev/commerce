<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\Quote;

use Siemendev\Checkout\Quote\AdditionalCost\QuoteAdditionalCostInterface;

class GiftCardAdditionalCost implements QuoteAdditionalCostInterface
{
    private int $value;
    private string $currency;

    public function getLabel(): string
    {
        return 'Gift Card';
    }

    public function setGiftCardValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->value * -1;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
