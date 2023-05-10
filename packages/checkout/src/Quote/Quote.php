<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote;

class Quote implements QuoteInterface
{
    private string $currency;

    /** @var array<QuoteItemInterface> */
    private array $items = [];

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    /** @return array<QuoteItemInterface> */
    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(QuoteItemInterface $item): static
    {
        $this->items[] = $item;

        return $this;
    }
}
