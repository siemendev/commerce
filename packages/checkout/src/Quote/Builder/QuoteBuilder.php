<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Builder;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Quote\Builder\Part\QuotePartBuilderInterface;
use Siemendev\Checkout\Quote\Quote;

class QuoteBuilder implements QuoteBuilderInterface
{
    /**
     * @param array<QuotePartBuilderInterface> $quotePartBuilders
     */
    public function __construct(
        private readonly array $quotePartBuilders = [],
    ) {
    }

    public function getQuote(CheckoutDataInterface $data): Quote
    {
        $quote = new Quote();

        foreach ($this->quotePartBuilders as $quotePartBuilder) {
            $quotePartBuilder->build($quote, $data);
        }

        return $quote;
    }
}
