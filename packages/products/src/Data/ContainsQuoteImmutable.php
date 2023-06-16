<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\Data;

use LogicException;
use Siemendev\Checkout\Products\Quote\Calculation\CheckoutQuoteCalculatorInterface;
use Siemendev\Checkout\Products\Quote\QuoteInterface;

/**
 * @see QuotedCheckoutDataInterface
 */
trait ContainsQuoteImmutable
{
    private QuoteInterface $quote;

    private string $calculatedHash = '';

    public function setQuote(?QuoteInterface $quote): static
    {
        throw new LogicException('Cannot set quote on immutable checkout data!');
    }

    public function getQuote(): QuoteInterface
    {
        if (!isset($this->quote)) {
            throw new LogicException(sprintf('The checkout data needs to be calculated before fetching it. Try using an implementation of %s to calculate the checkout data first!', CheckoutQuoteCalculatorInterface::class));
        }

        return $this->quote;
    }

    public function getCalculatedHash(): string
    {
        return $this->calculatedHash;
    }

    public function setCalculatedHash(string $hash): static
    {
        throw new LogicException('Cannot set calculated hash on immutable checkout data!');
    }
}
