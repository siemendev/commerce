<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote;

interface QuoteInterface
{
    public function setCurrency(string $currency): static;

    /** @return array<QuoteItemInterface> */
    public function getItems(): array;
}
