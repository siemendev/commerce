<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Data;

use Siemendev\Checkout\Products\Quote\QuoteInterface;

/**
 * @see QuotedCheckoutDataInterface
 */
trait ContainsQuote
{
    private ?QuoteInterface $quote = null;

    private string $calculatedHash = '';

    public function setQuote(?QuoteInterface $quote): static
    {
        $this->quote = $quote;

        return $this;
    }

    public function getQuote(): ?QuoteInterface
    {
        return $this->quote;
    }

    public function setCalculatedHash(string $hash): static
    {
        $this->calculatedHash = $hash;

        return $this;
    }

    public function getCalculatedHash(): string
    {
        return $this->calculatedHash;
    }
}
