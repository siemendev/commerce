<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Data;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Quote\QuoteInterface;

interface QuotedCheckoutDataInterface extends CheckoutDataInterface
{
    public function setQuote(?QuoteInterface $quote): static;

    public function getQuote(): ?QuoteInterface;

    public function setCalculatedHash(string $hash): static;

    public function getCalculatedHash(): string;
}
