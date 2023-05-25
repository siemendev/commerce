<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard;

class GiftCard implements GiftCardInterface
{
    private string $identifier;

    private int $value;

    private string $currency;

    private int $usedValue;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getUsedValue(): int
    {
        return $this->usedValue;
    }

    public function setUsedValue(int $usedValue): static
    {
        $this->usedValue = $usedValue;

        return $this;
    }
}
