<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Quote;

use Siemendev\Checkout\Data\CheckoutDataInterface;

interface QuoteGeneratorInterface
{
    /**
     * Generates a quote for the given checkout data. For internal use only, try using the
     * CheckoutQuoteCalculatorInterface when you need the quote in the checkout data to be updated.
     */
    public function generate(CheckoutDataInterface $data): QuoteInterface;
}
