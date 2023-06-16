<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\Data;

use LogicException;
use Siemendev\Checkout\Products\Quote\Calculation\CheckoutQuoteCalculatorInterface;
use Siemendev\Checkout\Products\Quote\QuoteInterface;

/**
 * @see QuotedCheckoutDataInterface
 */
trait ContainsQuote
{
    private QuoteInterface $quote;

    private string $calculatedHash = '';

    public function setQuote(?QuoteInterface $quote): static
    {
        $this->quote = $quote;

        return $this;
    }

    public function getQuote(): QuoteInterface
    {
        if (!isset($this->quote)) {
            throw new LogicException(sprintf('The checkout data needs to be calculated before fetching it. Try using an implementation of %s to calculate the checkout data first!', CheckoutQuoteCalculatorInterface::class));
        }

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
